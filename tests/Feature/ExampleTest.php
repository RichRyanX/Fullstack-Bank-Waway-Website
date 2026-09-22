<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Admin::create([
            'username' => 'admin',
            'password_hash' => 'password',
            'name' => 'Admin Utama',
            'role' => 'super_admin',
        ]);

        Setting::create([
            'site_name' => 'Bank Waway',
            'site_tagline' => 'Melayani masyarakat dengan layanan perbankan yang aman, sehat, dan terpercaya.',
        ]);
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
