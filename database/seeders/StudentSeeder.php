<?php

namespace Database\Seeders;

use App\Models\Institution;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $latis = Institution::where('name', 'Latis Education')->first();
        $tutor = Institution::where('name', 'Tutor Indonesia')->first();

        $students = [
            [
                'institution_id' => $latis->id,
                'nis' => '10001',
                'name' => 'Aditya Pratama',
                'email' => 'aditya.pratama@gmail.com',
            ],
            [
                'institution_id' => $latis->id,
                'nis' => '10002',
                'name' => 'Bintang Ramadhan',
                'email' => 'bintang.ramadhan@yahoo.com',
            ],
            [
                'institution_id' => $latis->id,
                'nis' => '10003',
                'name' => 'Citra Lestari',
                'email' => 'citra.lestari@latis.sch.id',
            ],
            [
                'institution_id' => $tutor->id,
                'nis' => '20001',
                'name' => 'Dimas Anggara',
                'email' => 'dimas.anggara@tutor.id',
            ],
            [
                'institution_id' => $tutor->id,
                'nis' => '20002',
                'name' => 'Eka Putri Rahayu',
                'email' => 'eka.putri@gmail.com',
            ],
            [
                'institution_id' => $tutor->id,
                'nis' => '20003',
                'name' => 'Fajar Maulana',
                'email' => 'fajar.m@gmail.com',
            ],
        ];

        foreach ($students as $data) {
            Student::firstOrCreate(['nis' => $data['nis']], $data);
        }
    }
}
