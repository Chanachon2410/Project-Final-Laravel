<?php

namespace Database\Seeders;

use App\Models\Level;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentTeacherLinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $studentUsers = User::role('Student')->get();
        $teacherUsers = User::role('Teacher')->get();
        $firstLevel = Level::first(); // Usually Pwc.1
        $bachelorLevel = Level::where('name', 'like', '%ปริญญาตรี%')->first();

        foreach ($studentUsers as $key => $user) {
            $targetLevelId = $firstLevel->id;
            $firstname = 'Student';
            $lastname = 'User ' . ($key + 1);
            
            if ($user->username === 'bachelor1' && $bachelorLevel) {
                $targetLevelId = $bachelorLevel->id;
                $firstname = 'สมชาย';
                $lastname = 'รักเรียน';
            }

            Student::create([
                'user_id' => $user->id,
                'student_code' => 'STU' . str_pad($key + 1, 4, '0', STR_PAD_LEFT),
                'firstname' => $firstname,
                'lastname' => $lastname,
                'level_id' => $targetLevelId,
                'citizen_id' => rand(1000000000000, 1999999999999),
            ]);
        }

        foreach ($teacherUsers as $key => $user) {
            Teacher::create([
                'user_id' => $user->id,
                'teacher_code' => 'TEA' . str_pad($key + 1, 3, '0', STR_PAD_LEFT),
                'title' => 'Mr.',
                'firstname' => 'Teacher',
                'lastname' => 'User ' . ($key + 1),
                'citizen_id' => rand(2000000000000, 2999999999999),
            ]);
        }
    }
}