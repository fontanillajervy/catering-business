<?php

namespace Tests\Feature;

use App\Models\Package;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    public function test_public_home_page_is_accessible(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_reservation_page_is_accessible(): void
    {
        $response = $this->get('/reservation');

        $response->assertStatus(200);
    }

    public function test_inquiry_page_is_accessible(): void
    {
        $response = $this->get('/inquiry');

        $response->assertStatus(200);
    }

    public function test_reservation_requires_two_day_lead_time(): void
    {
        Package::create([
            'name' => 'Classic Package',
            'slug' => 'classic-package',
            'price' => 500,
            'min_guests' => 20,
            'max_guests' => 200,
            'event_type' => 'Wedding',
        ]);

        $response = $this->from('/reservation')->post('/reservation', [
            'full_name' => 'Test User',
            'contact_number' => '09171234567',
            'email' => 'test@example.com',
            'address' => '123 Main Street',
            'event_type' => 'Wedding',
            'event_date' => now()->addDay()->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Sample Venue',
            'guest_count' => 50,
            'estimated_budget' => 10000,
            'package_id' => 1,
            'website' => '',
            'form_started' => now()->subSeconds(5)->timestamp,
            'g-recaptcha-response' => 'test',
        ]);

        $response->assertRedirect('/reservation');
        $response->assertSessionHasErrors('event_date');
    }

    public function test_reservation_rejects_invalid_contact_email_address_and_venue(): void
    {
        Package::create([
            'name' => 'Classic Package',
            'slug' => 'classic-package',
            'price' => 500,
            'min_guests' => 20,
            'max_guests' => 200,
            'event_type' => 'Wedding',
        ]);

        $response = $this->from('/reservation')->post('/reservation', [
            'full_name' => 'Test User',
            'contact_number' => '123',
            'email' => 'not-an-email',
            'address' => 'Apt',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(3)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'X',
            'guest_count' => 50,
            'estimated_budget' => 10000,
            'package_id' => 1,
            'website' => '',
            'form_started' => now()->timestamp,
            'g-recaptcha-response' => 'test',
        ]);

        $response->assertRedirect('/reservation');
        $response->assertSessionHasErrors(['contact_number', 'email', 'address', 'venue']);
    }

    public function test_reservation_accepts_valid_philippine_mobile_number_formats(): void
    {
        $request = new \Illuminate\Http\Request([
            'full_name' => 'Test User',
            'contact_number' => '+639814542318',
            'email' => 'valid@example.com',
            'address' => '123 Main Street, Cebu City',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(3)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Sample Venue Hall',
            'guest_count' => 50,
            'estimated_budget' => 10000,
            'package_id' => 1,
            'website' => '',
            'form_started' => now()->timestamp,
            'g-recaptcha-response' => 'test',
        ]);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), (new \App\Http\Requests\StoreReservationRequest)->rules());

        $this->assertFalse($validator->fails(), 'Expected valid Philippine mobile numbers to pass validation. Errors: ' . json_encode($validator->errors()->all()));

        $request->merge(['contact_number' => '+639814542318']);
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), (new \App\Http\Requests\StoreReservationRequest)->rules());

        $this->assertFalse($validator->fails(), 'Expected +63 format to pass validation. Errors: ' . json_encode($validator->errors()->all()));
    }

    public function test_reservation_rejects_non_philippine_number_formats(): void
    {
        $request = new \Illuminate\Http\Request([
            'full_name' => 'Test User',
            'contact_number' => '0917123456',
            'email' => 'valid@example.com',
            'address' => '123 Main Street, Cebu City',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(3)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Sample Venue Hall',
            'guest_count' => 50,
            'estimated_budget' => 10000,
            'package_id' => 1,
            'website' => '',
            'form_started' => now()->timestamp,
            'g-recaptcha-response' => 'test',
        ]);

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), (new \App\Http\Requests\StoreReservationRequest)->rules());

        $this->assertTrue($validator->fails(), 'Expected a non-Philippine number to fail validation.');
        $this->assertArrayHasKey('contact_number', $validator->errors()->toArray());
    }

    public function test_reservation_sends_confirmation_email_with_reservation_id_to_customer(): void
    {
        \Illuminate\Support\Facades\Mail::fake();
        $captchaVerifier = \Mockery::mock(\App\Services\RecaptchaVerifier::class);
        $captchaVerifier->shouldReceive('verify')->once()->andReturnTrue();
        $this->app->instance(\App\Services\RecaptchaVerifier::class, $captchaVerifier);

        \App\Models\Package::create([
            'name' => 'Classic Package',
            'slug' => 'classic-package',
            'price' => 500,
            'min_guests' => 20,
            'max_guests' => 200,
            'event_type' => 'Wedding',
        ]);
        $expectedTotal = (float) \App\Models\Package::findOrFail(1)->price * 50;

        $response = $this->from('/reservation')->post('/reservation', [
            'full_name' => 'Test User',
            'contact_number' => '+639814542318',
            'email' => 'customer@gmail.com',
            'address' => '123 Main Street, Cebu City',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(4)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Sample Venue Hall',
            'guest_count' => 50,
            'estimated_budget' => 10000,
            'package_id' => 1,
            'website' => '',
            'form_started' => now()->subSeconds(5)->timestamp,
            'g-recaptcha-response' => 'test',
        ]);

        $response->assertRedirect('/reservation');
        $response->assertSessionHasNoErrors();
        $this->assertSame($expectedTotal, (float) \App\Models\Reservation::latest('id')->firstOrFail()->estimated_budget);
        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\ReservationConfirmationMail::class, function ($mail) use ($expectedTotal) {
            return $mail->hasTo('customer@gmail.com')
                && $mail->reservationCode !== ''
            && $mail->estimatedBudget === $expectedTotal;
        });
    }

    public function test_admin_report_csv_export_uses_the_selected_period_summary(): void
    {
        $controller = app(\App\Http\Controllers\ReportController::class);
        $response = $controller->export(app(\App\Services\ReportService::class), 'daily');

        $csv = $response->getContent();

        $this->assertStringContainsString('Period', $csv);
        $this->assertStringContainsString('daily', strtolower($csv));
        $this->assertStringContainsString('Reservations', $csv);
    }

    public function test_admin_cannot_manually_change_total_and_can_update_payment_amount(): void
    {
        $reservation = \App\Models\Reservation::create([
            'package_id' => 1,
            'full_name' => 'Alice Client',
            'contact_number' => '09170000001',
            'email' => 'alice@example.com',
            'address' => '123 Alice St',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(5)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Alice Venue',
            'guest_count' => 80,
            'estimated_budget' => 25000,
            'status' => 'confirmed',
            'payment_status' => 'Unpaid',
            'payment_type' => 'Unpaid',
            'amount_paid' => 0,
            'balance' => 25000,
            'reservation_code' => 'RES-PAYMENT-001',
        ]);

        $request = new \Illuminate\Http\Request([
            'estimated_budget' => 35000,
            'amount_paid' => 8000,
        ]);

        app(\App\Http\Controllers\AdminController::class)->updateReservationStatus($request, $reservation);
        $reservation->refresh();

        $this->assertSame(25000.0, (float) $reservation->estimated_budget);
        $this->assertSame(8000.0, (float) $reservation->amount_paid);
        $this->assertSame('Downpayment', $reservation->payment_status);
        $this->assertSame(17000.0, (float) $reservation->balance);

        $fullyPaidRequest = new \Illuminate\Http\Request([
            'estimated_budget' => 35000,
            'amount_paid' => 25000,
            'mark_fully_paid' => true,
        ]);

        app(\App\Http\Controllers\AdminController::class)->updateReservationStatus($fullyPaidRequest, $reservation);
        $reservation->refresh();

        $this->assertSame(25000.0, (float) $reservation->estimated_budget);
        $this->assertSame('Fully Paid', $reservation->payment_status);
        $this->assertSame('Full Payment', $reservation->payment_type);
        $this->assertSame(25000.0, (float) $reservation->amount_paid);
        $this->assertSame(0.0, (float) $reservation->balance);
    }

    public function test_admin_dashboard_does_not_include_calendar_data(): void
    {
        $bookingDate = now()->startOfMonth()->addDays(3);

        \App\Models\Reservation::create([
            'package_id' => 1,
            'full_name' => 'Alice Client',
            'contact_number' => '09170000001',
            'email' => 'alice@example.com',
            'address' => '123 Alice St',
            'event_type' => 'Wedding',
            'event_date' => $bookingDate->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Alice Venue',
            'guest_count' => 80,
            'estimated_budget' => 20000,
            'status' => 'confirmed',
            'payment_status' => 'Downpayment',
            'payment_type' => 'Downpayment',
            'amount_paid' => 3000,
            'balance' => 17000,
            'reservation_code' => 'RES-SIDEBAR-001',
        ]);

        \App\Models\Reservation::create([
            'package_id' => 1,
            'full_name' => 'Bob Client',
            'contact_number' => '09170000002',
            'email' => 'bob@example.com',
            'address' => '456 Bob St',
            'event_type' => 'Birthday',
            'event_date' => $bookingDate->toDateString(),
            'event_time' => '17:00',
            'venue' => 'Bob Venue',
            'guest_count' => 50,
            'estimated_budget' => 12000,
            'status' => 'pending',
            'payment_status' => 'Unpaid',
            'payment_type' => 'Unpaid',
            'amount_paid' => 0,
            'balance' => 12000,
            'reservation_code' => 'RES-SIDEBAR-002',
        ]);

        $response = app(\App\Http\Controllers\AdminController::class)->index();
        $data = $response->getData(true);

        $this->assertArrayNotHasKey('sidebarCalendar', $data);
        $this->assertArrayNotHasKey('selectedReservations', $data);
    }

    public function test_admin_can_track_reservation_payment_status_and_balance(): void
    {
        $reservation = \App\Models\Reservation::create([
            'client_id' => null,
            'package_id' => 1,
            'full_name' => 'Test Client',
            'contact_number' => '09814542318',
            'email' => 'client@example.com',
            'address' => '123 Test Street, Cebu City',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(5)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Nustad Hall',
            'guest_count' => 100,
            'estimated_budget' => 25000,
            'status' => 'pending',
            'reservation_code' => 'RES-TEST-001',
        ]);

        $request = new \Illuminate\Http\Request([
            'status' => 'completed',
            'payment_status' => 'Downpayment',
            'payment_type' => 'Downpayment',
            'amount_paid' => 8000,
        ]);

        $response = app(\App\Http\Controllers\AdminController::class)->updateReservationStatus($request, $reservation);

        $this->assertSame('completed', $reservation->fresh()->status);
        $this->assertSame('Downpayment', $reservation->fresh()->payment_status);
        $this->assertSame('Downpayment', $reservation->fresh()->payment_type);
        $this->assertSame(8000.0, (float) $reservation->fresh()->amount_paid);
        $this->assertSame(17000.0, (float) $reservation->fresh()->balance);
        $this->assertNotNull($response);
    }

    public function test_admin_reservations_can_be_filtered_by_status_and_payment_status(): void
    {
        \App\Models\Reservation::create([
            'package_id' => 1,
            'full_name' => 'Alice Client',
            'contact_number' => '09171234567',
            'email' => 'alice@example.com',
            'address' => '123 Alice St',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(4)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Alice Venue',
            'guest_count' => 80,
            'estimated_budget' => 20000,
            'status' => 'confirmed',
            'payment_status' => 'Downpayment',
            'payment_type' => 'Downpayment',
            'amount_paid' => 6000,
            'balance' => 14000,
            'reservation_code' => 'RES-FILT-001',
        ]);

        \App\Models\Reservation::create([
            'package_id' => 1,
            'full_name' => 'Bob Client',
            'contact_number' => '09181234567',
            'email' => 'bob@example.com',
            'address' => '456 Bob St',
            'event_type' => 'Birthday',
            'event_date' => now()->addDays(7)->toDateString(),
            'event_time' => '17:00',
            'venue' => 'Bob Venue',
            'guest_count' => 50,
            'estimated_budget' => 12000,
            'status' => 'pending',
            'payment_status' => 'Unpaid',
            'payment_type' => 'Unpaid',
            'amount_paid' => 0,
            'balance' => 12000,
            'reservation_code' => 'RES-FILT-002',
        ]);

        $request = new \Illuminate\Http\Request([
            'status' => 'confirmed',
            'payment_status' => 'Downpayment',
        ]);

        $response = app(\App\Http\Controllers\AdminController::class)->reservations($request);
        $data = $response->getData(true);

        $this->assertCount(1, $data['reservations']);
        $this->assertSame('Alice Client', $data['reservations'][0]->full_name);
        $this->assertSame('confirmed', $data['filterStatus']);
        $this->assertSame('Downpayment', $data['filterPaymentStatus']);
    }

    public function test_admin_reservations_can_be_filtered_by_date_range_and_customer_search(): void
    {
        \App\Models\Reservation::create([
            'package_id' => 1,
            'full_name' => 'Alice Client',
            'contact_number' => '09170000001',
            'email' => 'alice@example.com',
            'address' => '123 Alice St',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(4)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Alice Venue',
            'guest_count' => 80,
            'estimated_budget' => 20000,
            'status' => 'confirmed',
            'payment_status' => 'Downpayment',
            'payment_type' => 'Downpayment',
            'amount_paid' => 3000,
            'balance' => 17000,
            'reservation_code' => 'RES-FILT-SEARCH-001',
        ]);

        \App\Models\Reservation::create([
            'package_id' => 1,
            'full_name' => 'Bob Client',
            'contact_number' => '09180000002',
            'email' => 'bob@example.com',
            'address' => '456 Bob St',
            'event_type' => 'Birthday',
            'event_date' => now()->addDays(15)->toDateString(),
            'event_time' => '17:00',
            'venue' => 'Bob Venue',
            'guest_count' => 50,
            'estimated_budget' => 12000,
            'status' => 'pending',
            'payment_status' => 'Unpaid',
            'payment_type' => 'Unpaid',
            'amount_paid' => 0,
            'balance' => 12000,
            'reservation_code' => 'RES-FILT-SEARCH-002',
        ]);

        $request = new \Illuminate\Http\Request([
            'search' => 'alice',
            'date_from' => now()->addDays(3)->toDateString(),
            'date_to' => now()->addDays(10)->toDateString(),
        ]);

        $response = app(\App\Http\Controllers\AdminController::class)->reservations($request);
        $data = $response->getData(true);

        $this->assertCount(1, $data['reservations']);
        $this->assertSame('Alice Client', $data['reservations'][0]->full_name);
        $this->assertSame('alice', $data['search']);
        $this->assertSame(now()->addDays(3)->toDateString(), $data['dateFrom']);
    }

    public function test_admin_reservations_export_uses_filtered_results(): void
    {
        \App\Models\Reservation::create([
            'package_id' => 1,
            'full_name' => 'Alice Client',
            'contact_number' => '09170000003',
            'email' => 'alice@example.com',
            'address' => '123 Alice St',
            'event_type' => 'Wedding',
            'event_date' => now()->addDays(4)->toDateString(),
            'event_time' => '18:00',
            'venue' => 'Alice Venue',
            'guest_count' => 80,
            'estimated_budget' => 20000,
            'status' => 'confirmed',
            'payment_status' => 'Fully Paid',
            'payment_type' => 'Full Payment',
            'amount_paid' => 20000,
            'balance' => 0,
            'reservation_code' => 'RES-FILT-EXPORT-001',
        ]);

        \App\Models\Reservation::create([
            'package_id' => 1,
            'full_name' => 'Bob Client',
            'contact_number' => '09180000004',
            'email' => 'bob@example.com',
            'address' => '456 Bob St',
            'event_type' => 'Birthday',
            'event_date' => now()->addDays(12)->toDateString(),
            'event_time' => '17:00',
            'venue' => 'Bob Venue',
            'guest_count' => 50,
            'estimated_budget' => 12000,
            'status' => 'pending',
            'payment_status' => 'Unpaid',
            'payment_type' => 'Unpaid',
            'amount_paid' => 0,
            'balance' => 12000,
            'reservation_code' => 'RES-FILT-EXPORT-002',
        ]);

        $response = app(\App\Http\Controllers\AdminController::class)->exportReservationsCsv(new \Illuminate\Http\Request([
            'status' => 'confirmed',
            'search' => 'alice',
        ]));

        $csv = $response->getContent();

        $this->assertStringContainsString('RES-FILT-EXPORT-001', $csv);
        $this->assertStringNotContainsString('RES-FILT-EXPORT-002', $csv);
    }
}
