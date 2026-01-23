<?php

namespace Database\Seeders;

use App\Models\Semester;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Semester::firstOrCreate(
            [
                'semester' => 1,
                'year' => 2025,
            ],
            [
                'registration_start_date' => '2025-05-06',
                'registration_end_date' => '2025-05-18',
                'late_registration_start_date' => '2025-05-19',
                'late_registration_end_date' => '2025-05-31',
                'is_active' => true,
            ]
        );
    }
}
