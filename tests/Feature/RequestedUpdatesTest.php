<?php

namespace Tests\Feature;

use App\Http\Controllers\ActivityLogController;
use App\Http\Requests\StoreInquiryRequest;
use App\Http\Controllers\AdminController;
use App\Models\ActivityLog;
use App\Models\Client;
use App\Models\GalleryItem;
use App\Models\Inquiry;
use App\Models\Package;
use App\Models\Reservation;
use App\Models\User;
use App\Mail\InquiryReplyMail;
use App\Mail\ReservationStatusMail;
use App\Services\BackupService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RequestedUpdatesTest extends TestCase
{
    public function test_package_schema_supports_images(): void
    {
        $this->assertTrue(Schema::hasColumn('packages', 'image_path'));
    }

    public function test_activity_log_page_size_cannot_be_less_than_ten(): void
    {
        foreach (range(1, 12) as $index) {
            ActivityLog::create([
                'action' => 'Action ' . $index,
                'activity_date' => now()->toDateString(),
                'activity_time' => now()->format('H:i:s'),
            ]);
        }

        $response = app(ActivityLogController::class)->index(new Request(['per_page' => 1]));

        $this->assertSame(10, $response->getData(true)['logs']->perPage());
    }

    public function test_gallery_can_filter_other_events(): void
    {
        GalleryItem::create(['title' => 'Other celebration', 'image_path' => 'gallery/other.jpg', 'event_type' => 'Other Events']);
        GalleryItem::create(['title' => 'Wedding celebration', 'image_path' => 'gallery/wedding.jpg', 'event_type' => 'Wedding']);

        $this->get('/gallery?event_type=Other%20Events')
            ->assertOk()
            ->assertSeeText('Other celebration')
            ->assertDontSeeText('Wedding celebration');
    }

    public function test_inquiry_phone_must_use_plus_63_and_exactly_ten_digits(): void
    {
        $request = new Request(['contact_number' => '+639123456789']);
        $phoneRules = (new StoreInquiryRequest())->rules()['contact_number'];
        $validator = Validator::make($request->all(), ['contact_number' => $phoneRules]);
        $this->assertFalse($validator->fails());

        $request->merge(['contact_number' => '09123456789']);
        $validator = Validator::make($request->all(), ['contact_number' => $phoneRules]);
        $this->assertTrue($validator->fails());
    }

    public function test_reservation_status_changes_email_the_customer(): void
    {
        Mail::fake();
        $reservation = Reservation::create([
            'full_name' => 'Status Client',
            'contact_number' => '+639123456789',
            'email' => 'status@example.com',
            'address' => '123 Example Street',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(5)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Example Hall',
            'guest_count' => 50,
            'estimated_budget' => 25000,
            'status' => 'pending',
            'reservation_code' => 'RES-STATUS-001',
        ]);

        app(AdminController::class)->updateReservationStatus(new Request(['status' => 'confirmed']), $reservation);

        Mail::assertSent(ReservationStatusMail::class, fn ($mail) => $mail->hasTo('status@example.com')
            && $mail->reservationCode === 'RES-STATUS-001'
            && $mail->status === 'confirmed');
    }

    public function test_admin_inquiry_reply_is_emailed_to_the_customer(): void
    {
        Mail::fake();
        $inquiry = Inquiry::create([
            'full_name' => 'Inquiry Client',
            'contact_number' => '+639123456789',
            'email' => 'inquiry@example.com',
            'subject' => 'Wedding catering',
            'category' => 'Wedding',
            'message' => 'Please send package details.',
        ]);

        $this->withSession(['is_admin' => true])
            ->post(route('admin.inquiries.reply', $inquiry), ['reply' => 'We would be happy to help.'])
            ->assertRedirect(route('admin.inquiries.show', $inquiry));

        Mail::assertSent(InquiryReplyMail::class, fn ($mail) => $mail->hasTo('inquiry@example.com')
            && $mail->inquirySubject === 'Wedding catering'
            && $mail->reply === 'We would be happy to help.');
        $this->assertDatabaseHas('inquiries', [
            'id' => $inquiry->id,
            'admin_reply' => 'We would be happy to help.',
            'status' => 'responded',
        ]);
    }

    public function test_password_reset_email_token_remains_valid_and_resets_password(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email' => 'team-admin@example.com']);

        $this->from(route('password.request'))
            ->post(route('password.email'), ['email' => $user->email])
            ->assertRedirect(route('password.request'))
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
        $resetNotification = Notification::sent($user, ResetPassword::class)->first();
        $this->assertNotNull($resetNotification);
        $this->assertTrue(Password::broker()->tokenExists($user, $resetNotification->token));

        $this->post(route('password.update'), [
            'email' => $user->email,
            'token' => $resetNotification->token,
            'password' => 'NewSecurePassword123!',
            'password_confirmation' => 'NewSecurePassword123!',
        ])->assertRedirect(route('admin.login'));

        $this->assertTrue(Hash::check('NewSecurePassword123!', $user->fresh()->password));
    }

    public function test_backup_restores_package_rows(): void
    {
        $package = Package::create([
            'name' => 'Original package',
            'slug' => 'original-package',
            'price' => 500,
            'min_guests' => 10,
            'max_guests' => 100,
        ]);
        $client = Client::create(['name' => 'Backup Client', 'email' => 'backup@example.com']);
        $reservation = Reservation::create([
            'client_id' => $client->id,
            'package_id' => $package->id,
            'full_name' => 'Backup Client',
            'contact_number' => '+639123456789',
            'email' => $client->email,
            'address' => '123 Example Street',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(5)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Example Hall',
            'guest_count' => 50,
            'estimated_budget' => 25000,
            'reservation_code' => 'RES-BACKUP-001',
        ]);
        $backupService = app(BackupService::class);
        $backupPath = $backupService->create();
        $backupName = basename($backupPath);

        try {
            $package->update(['name' => 'Changed package']);
            $restoredRows = $backupService->restore($backupName);

            $this->assertGreaterThan(0, $restoredRows);
            $this->assertDatabaseHas('packages', ['id' => $package->id, 'name' => 'Original package']);
            $this->assertDatabaseHas('reservations', ['id' => $reservation->id, 'reservation_code' => 'RES-BACKUP-001']);
        } finally {
            $backupService->delete($backupName);
        }
    }
}