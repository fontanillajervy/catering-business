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
            'form_started' => now()->timestamp,
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

    public function test_admin_report_csv_export_uses_the_selected_period_summary(): void
    {
        $controller = app(\App\Http\Controllers\ReportController::class);
        $response = $controller->export(app(\App\Services\ReportService::class), 'daily');

        $csv = $response->getContent();

        $this->assertStringContainsString('Period', $csv);
        $this->assertStringContainsString('daily', strtolower($csv));
        $this->assertStringContainsString('Reservations', $csv);
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
}
