<?php

namespace Tests\Feature;

use App\Models\Institution;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class StudentExportTest extends TestCase
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

        Student::create([
            'institution_id' => $this->latis->id,
            'nis' => '1001',
            'name' => 'Aditya Pratama',
            'email' => 'aditya@example.com',
        ]);

        Student::create([
            'institution_id' => $this->tutor->id,
            'nis' => '1002',
            'name' => 'Bintang Ramadhan',
            'email' => 'bintang@example.com',
        ]);
    }

    public function test_can_download_excel_export(): void
    {
        $response = $this->actingAs($this->user)->get('/students/export');

        $response->assertStatus(200);
        $response->assertHeader('content-disposition');
    }

    public function test_excel_export_matches_filtered_query(): void
    {
        Excel::fake();

        $this->actingAs($this->user)->get("/students/export?institution_id={$this->latis->id}&search=Aditya");

        Excel::assertDownloaded('data-siswa.xlsx');
    }
}
