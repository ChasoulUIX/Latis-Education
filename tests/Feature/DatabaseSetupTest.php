<?php

namespace Tests\Feature;

use App\Models\Institution;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSetupTest extends TestCase
{
    use RefreshDatabase;

    public function test_institutions_and_user_are_seeded(): void
    {
        $this->seed();

        $this->assertDatabaseHas('institutions', [
            'name' => 'Latis Education',
        ]);

        $this->assertDatabaseHas('institutions', [
            'name' => 'Tutor Indonesia',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'admin@latis.com',
            'position' => 'Fullstack Developer',
        ]);
    }

    public function test_student_belongs_to_institution(): void
    {
        $institution = Institution::create(['name' => 'Latis Education']);
        $student = Student::create([
            'institution_id' => $institution->id,
            'nis' => '123456',
            'name' => 'Ahmad Fulan',
            'email' => 'ahmad@example.com',
            'photo' => null,
        ]);

        $this->assertInstanceOf(Institution::class, $student->institution);
        $this->assertEquals('Latis Education', $student->institution->name);
        $this->assertTrue($institution->students->contains($student));
    }
}
