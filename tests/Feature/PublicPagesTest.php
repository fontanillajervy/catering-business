<?php

namespace Tests\Feature;

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
}
