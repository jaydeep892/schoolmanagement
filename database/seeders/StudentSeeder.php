<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'name' => 'Ramesh',
                'email' => 'ramesh@testmail.com',
                'parent_id' => 1,
            ],
            [
                'name' => 'Suresh',
                'email' => 'suresh@testmail.com',
                'parent_id' => 1,
            ],
            [
                'name' => 'Manish',
                'email' => 'manish@testmail.com',
                'parent_id' => 2,
            ],
            [
                'name' => 'Nisha',
                'email' => 'nisha@testmail.com',
                'parent_id' => 2,
            ],
        ];
        Student::insert($students);
    }
}
