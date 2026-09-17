<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'name' => 'Kandidat Developer',
            'email' => 'kandidat@example.com',
            'position' => 'Senior Fullstack Engineer',
            'image' => null,
        ]);
    }

    public function test_profile_page_displays_candidate_info(): void
    {
        $response = $this->actingAs($this->user)->get('/profile');

        $response->assertStatus(200);
        $response->assertSee('Kandidat Developer');
        $response->assertSee('Senior Fullstack Engineer');
        $response->assertSee('kandidat@example.com');
    }

    public function test_candidate_can_update_profile_and_avatar(): void
    {
        Storage::fake('public');

        $avatar = UploadedFile::fake()->image('avatar.jpg', 200, 200)->size(80);

        $response = $this->actingAs($this->user)->put('/profile', [
            'name' => 'Kandidat Hebat',
            'position' => 'Lead Software Engineer',
            'image' => $avatar,
        ]);

        $response->assertRedirect('/profile');
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Kandidat Hebat',
            'position' => 'Lead Software Engineer',
        ]);

        $this->user->refresh();
        $this->assertNotNull($this->user->image);
        Storage::disk('public')->assertExists($this->user->image);
    }
}
