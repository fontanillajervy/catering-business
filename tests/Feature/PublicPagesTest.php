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
}
