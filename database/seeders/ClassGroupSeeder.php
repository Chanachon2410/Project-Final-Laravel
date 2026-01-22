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

        // Assign students to this class group (Pwc.1)
        $students = Student::whereHas('user', function($q) {
            $q->where('username', '!=', 'bachelor1');
        })->take(3)->get();
        
        foreach ($students as $student) {
            $student->update(['class_group_id' => $classGroup->id]);
        }

        // === Bachelor Class Group ===
        $bachelorLevel = Level::where('name', 'like', '%ปริญญาตรี%')->first();
        // Try to find a major for bachelor (using 3901 as placeholder or same major)
        // Ideally we should have a specific major for Bachelor in MajorSeeder, but for now we reuse or find one.
        // Let's reuse '2901' (IT) but technically it should be different. 
        // For simplicity, let's just use the same Major ID but different Class Group.
        // OR better, create a new Major or use one if appropriate. 
        // In MajorSeeder we have '3901' (IT Pws). Let's use that one or create one on fly if needed, 
        // but '3901' is 'เทคโนโลยีสารสนเทศ' (PWS). 
        // Let's assume 3901 is okay or we just pick one.
        $bachelorMajor = Major::where('major_code', '4204')->first() ?? $major;

        if ($bachelorLevel) {
            $bachelorClassGroup = ClassGroup::create([
                'course_group_code' => 'TBD68-1',
                'course_group_name' => 'เทคโนโลยีธุรกิจดิจิทัล (ต่อเนื่อง) 1',
                'level_id' => $bachelorLevel->id,
                'level_year' => 1,
                'major_id' => $bachelorMajor->id,
                'teacher_advisor_id' => $advisor->id,
            ]);

            $bachelorStudent = Student::whereHas('user', function($q) {
                $q->where('username', 'bachelor1');
            })->first();

            if ($bachelorStudent) {
                $bachelorStudent->update(['class_group_id' => $bachelorClassGroup->id]);
            }
        }
    }
}
