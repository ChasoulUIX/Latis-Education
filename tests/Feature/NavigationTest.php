<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_sidebar_contains_required_navigation_items(): void
    {
        $user = User::factory()->create([
            'name' => 'Kandidat Admin',
            'position' => 'Fullstack Developer',
        ]);

        $response = $this->actingAs($user)->get('/students');

        $response->assertStatus(200);
        $response->assertSee('Data Siswa');
        $response->assertSee('Profile');
        $response->assertSee('Logout');
        $response->assertSee('Kandidat Admin');
    }
}
