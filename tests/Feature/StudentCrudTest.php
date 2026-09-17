<?php

namespace Tests\Feature;

use App\Models\Institution;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudentCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Institution $institution1;
    protected Institution $institution2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->institution1 = Institution::create(['name' => 'Latis Education']);
        $this->institution2 = Institution::create(['name' => 'Tutor Indonesia']);
    }

    public function test_can_create_student_with_valid_data(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('student.jpg', 100, 100)->size(80); // 80KB

        $response = $this->actingAs($this->user)->post('/students', [
            'institution_id' => $this->institution1->id,
            'nis' => '10001',
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'photo' => $file,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'nis' => '10001',
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'institution_id' => $this->institution1->id,
        ]);

        $student = Student::where('nis', '10001')->first();
        $this->assertNotNull($student->photo);
        Storage::disk('public')->assertExists($student->photo);
    }

    public function test_nis_must_be_numeric_and_unique(): void
    {
        Student::create([
            'institution_id' => $this->institution1->id,
            'nis' => '10001',
            'name' => 'Existing Student',
            'email' => 'exist@example.com',
        ]);

        // NIS duplicate
        $responseDuplicate = $this->actingAs($this->user)->post('/students', [
            'institution_id' => $this->institution1->id,
            'nis' => '10001',
            'name' => 'New Student',
            'email' => 'new@example.com',
        ]);
        $responseDuplicate->assertSessionHasErrors(['nis']);

        // NIS non-numeric
        $responseNonNumeric = $this->actingAs($this->user)->post('/students', [
            'institution_id' => $this->institution1->id,
            'nis' => 'ABC1234',
            'name' => 'New Student',
            'email' => 'new@example.com',
        ]);
        $responseNonNumeric->assertSessionHasErrors(['nis']);
    }

    public function test_photo_auto_compresses_when_exceeding_100kb(): void
    {
        Storage::fake('public');

        // Size > 100KB (e.g. 500KB image)
        $largeFile = UploadedFile::fake()->image('large.jpg', 800, 800)->size(500);

        $response = $this->actingAs($this->user)->post('/students', [
            'institution_id' => $this->institution1->id,
            'nis' => '10002',
            'name' => 'Auto Compressed Photo Student',
            'email' => 'compress@example.com',
            'photo' => $largeFile,
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'nis' => '10002',
            'name' => 'Auto Compressed Photo Student',
        ]);

        $student = Student::where('nis', '10002')->first();
        $this->assertNotNull($student->photo);
        Storage::disk('public')->assertExists($student->photo);

        // Stored file must be <= 100KB (102400 bytes)
        $storedSize = Storage::disk('public')->size($student->photo);
        $this->assertLessThanOrEqual(100 * 1024, $storedSize);
    }

    public function test_photo_format_must_be_jpg_or_png(): void
    {
        Storage::fake('public');

        // Invalid format (PDF)
        $invalidFile = UploadedFile::fake()->create('doc.pdf', 50, 'application/pdf');
        $responseInvalid = $this->actingAs($this->user)->post('/students', [
            'institution_id' => $this->institution1->id,
            'nis' => '10003',
            'name' => 'Invalid Photo Student',
            'email' => 'invalid@example.com',
            'photo' => $invalidFile,
        ]);
        $responseInvalid->assertSessionHasErrors(['photo']);
    }

    public function test_can_update_student(): void
    {
        $student = Student::create([
            'institution_id' => $this->institution1->id,
            'nis' => '10004',
            'name' => 'Original Name',
            'email' => 'original@example.com',
        ]);

        $response = $this->actingAs($this->user)->put("/students/{$student->id}", [
            'institution_id' => $this->institution2->id,
            'nis' => '10004',
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $response->assertRedirect('/students');
        $this->assertDatabaseHas('students', [
            'id' => $student->id,
            'institution_id' => $this->institution2->id,
            'nis' => '10004',
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function test_can_delete_student_and_its_photo(): void
    {
        Storage::fake('public');

        $path = UploadedFile::fake()->image('photo.png', 50, 50)->size(50)->store('students', 'public');

        $student = Student::create([
            'institution_id' => $this->institution1->id,
            'nis' => '10005',
            'name' => 'To Delete',
            'email' => 'delete@example.com',
            'photo' => $path,
        ]);

        $response = $this->actingAs($this->user)->delete("/students/{$student->id}");

        $response->assertRedirect('/students');
        $this->assertDatabaseMissing('students', [
            'id' => $student->id,
        ]);
        Storage::disk('public')->assertMissing($path);
    }
}
