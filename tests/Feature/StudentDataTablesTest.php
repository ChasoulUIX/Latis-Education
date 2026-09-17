<?php

namespace Tests\Feature;

use App\Models\Institution;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentDataTablesTest extends TestCase
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

        Student::create([
            'institution_id' => $this->latis->id,
            'nis' => '2001',
            'name' => 'Citra Lestari',
            'email' => 'citra@example.com',
        ]);
    }

    public function test_datatables_returns_all_data_when_unfiltered(): void
    {
        $response = $this->actingAs($this->user)->getJson('/students/data');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    public function test_datatables_filters_by_institution(): void
    {
        $response = $this->actingAs($this->user)->getJson("/students/data?institution_id={$this->latis->id}");

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
        $response->assertJsonFragment(['nis' => '1001']);
        $response->assertJsonFragment(['nis' => '2001']);
        $response->assertJsonMissing(['nis' => '1002']);
    }

    public function test_datatables_searches_only_nis_and_name(): void
    {
        // Search by NIS
        $responseNis = $this->actingAs($this->user)->getJson('/students/data?search=1002');
        $responseNis->assertStatus(200);
        $responseNis->assertJsonCount(1, 'data');
        $responseNis->assertJsonFragment(['nis' => '1002']);

        // Search by Name
        $responseName = $this->actingAs($this->user)->getJson('/students/data?search=Citra');
        $responseName->assertStatus(200);
        $responseName->assertJsonCount(1, 'data');
        $responseName->assertJsonFragment(['name' => 'Citra Lestari']);

        // Search on Email must not match since search is restricted to NIS & Nama
        $responseEmail = $this->actingAs($this->user)->getJson('/students/data?search=aditya@example.com');
        $responseEmail->assertStatus(200);
        $responseEmail->assertJsonCount(0, 'data');
    }
}
