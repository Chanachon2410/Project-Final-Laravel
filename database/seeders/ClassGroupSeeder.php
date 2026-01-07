<?php

namespace Database\Seeders;

use App\Models\ClassGroup;
use App\Models\Level;
use App\Models\Major;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $major = Major::where('major_code', '2901')->first();
        $level = Level::where('name', 'ปวช.1')->first();
        $advisor = Teacher::first();

        $classGroup = ClassGroup::create([
            'course_group_code' => 'IT67-1',
            'course_group_name' => 'IT-1',
            'level_id' => $level->id,
            'level_year' => 1,
            'major_id' => $major->id,
            'teacher_advisor_id' => $advisor->id,
        ]);

        // Assign students to this class group
        $students = Student::take(3)->get();
        foreach ($students as $student) {
            $student->update(['class_group_id' => $classGroup->id]);
        }
    }
}
