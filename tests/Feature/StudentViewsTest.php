<?php

namespace Tests\Feature;

use App\Models\Institution;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentViewsTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Institution $latis;
    protected Institution $tutor;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->latis = Institution::create(['name' => 'Latis Education']);
        $this->tutor = Institution::create(['name' => 'Tutor Indonesia']);
    }

    public function test_create_view_renders_institution_options(): void
    {
        $response = $this->actingAs($this->user)->get('/students/create');

        $response->assertStatus(200);
        $response->assertSee('Tambah Data Siswa');
        $response->assertSee('Latis Education');
        $response->assertSee('Tutor Indonesia');
        $response->assertSee('100KB');
    }

    public function test_edit_view_renders_existing_student_data(): void
    {
        $student = Student::create([
            'institution_id' => $this->latis->id,
            'nis' => '998877',
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
        ]);

        $response = $this->actingAs($this->user)->get("/students/{$student->id}/edit");

        $response->assertStatus(200);
        $response->assertSee('Edit Data Siswa');
        $response->assertSee('998877');
        $response->assertSee('Siti Nurhaliza');
        $response->assertSee('siti@example.com');
    }
}
