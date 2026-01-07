<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'subject_code' => 'CS101',
                'subject_name' => 'การพัฒนาเว็บแอปพลิเคชั่น',
                'credit' => 3,
                'hour_theory' => 2,
                'hour_practical' => 2,
            ],
            [
                'subject_code' => 'CS102',
                'subject_name' => 'การพัฒนาซอฟต์แวร์รูปแบบเดฟออปส์',
                'credit' => 3,
                'hour_theory' => 2,
                'hour_practical' => 2,
            ],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(['subject_code' => $subject['subject_code']], $subject);
        }
    }
}
