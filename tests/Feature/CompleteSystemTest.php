<?php

namespace Tests\Feature;

use App\Models\Institution;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CompleteSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_full_system_lifecycle_end_to_end(): void
    {
        Storage::fake('public');

        // 1. Seed database
        $this->seed();

        // 2. Login
        $loginResponse = $this->post('/login', [
            'email' => 'admin@latis.com',
            'password' => 'password123',
        ]);
        $loginResponse->assertRedirect('/students');
        $this->assertAuthenticated();

        // 3. Check DataTables endpoint
        $latis = Institution::where('name', 'Latis Education')->first();
        $dtResponse = $this->getJson("/students/data?institution_id={$latis->id}");
        $dtResponse->assertStatus(200);
        $dtResponse->assertJsonStructure(['data', 'recordsTotal', 'recordsFiltered']);

        // 4. Create New Student
        $photo = UploadedFile::fake()->image('student_test.png')->size(75);
        $createResponse = $this->post('/students', [
            'institution_id' => $latis->id,
            'nis' => '99001',
            'name' => 'Siswa Baru Unggulan',
            'email' => 'siswa.baru@latis.sch.id',
            'photo' => $photo,
        ]);
        $createResponse->assertRedirect('/students');
        $this->assertDatabaseHas('students', ['nis' => '99001', 'name' => 'Siswa Baru Unggulan']);

        $createdStudent = Student::where('nis', '99001')->first();
        $this->assertNotNull($createdStudent->photo);
        Storage::disk('public')->assertExists($createdStudent->photo);

        // 5. Update Student
        $tutor = Institution::where('name', 'Tutor Indonesia')->first();
        $updateResponse = $this->put("/students/{$createdStudent->id}", [
            'institution_id' => $tutor->id,
            'nis' => '99001',
            'name' => 'Siswa Baru Unggulan (Updated)',
            'email' => 'siswa.baru.updated@tutor.id',
        ]);
        $updateResponse->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'id' => $createdStudent->id,
            'name' => 'Siswa Baru Unggulan (Updated)',
            'institution_id' => $tutor->id,
        ]);

        // 6. Test Excel Export
        $exportResponse = $this->get("/students/export?institution_id={$tutor->id}&search=Unggulan");
        $exportResponse->assertStatus(200);
        $exportResponse->assertHeader('content-disposition');

        // 7. Update Profile Candidate
        $avatar = UploadedFile::fake()->image('candidate.jpg')->size(90);
        $profileResponse = $this->put('/profile', [
            'name' => 'Kandidat Lead Architect',
            'position' => 'Senior Fullstack Engineer',
            'image' => $avatar,
        ]);
        $profileResponse->assertRedirect('/profile');
        $this->assertDatabaseHas('users', [
            'email' => 'admin@latis.com',
            'name' => 'Kandidat Lead Architect',
            'position' => 'Senior Fullstack Engineer',
        ]);

        // 8. Logout
        $logoutResponse = $this->post('/logout');
        $logoutResponse->assertRedirect('/login');
        $this->assertGuest();
    }
}
