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
        $firstLevel = Level::first();

        foreach ($studentUsers as $key => $user) {
            Student::create([
                'user_id' => $user->id,
                'student_code' => 'STU' . str_pad($key + 1, 4, '0', STR_PAD_LEFT),
                'firstname' => 'Student',
                'lastname' => 'User ' . ($key + 1),
                'level_id' => $firstLevel->id,
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