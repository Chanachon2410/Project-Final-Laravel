<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use App\Models\ClassGroup;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationReportPdfController extends Controller
{
    public function preview(Request $request)
    {
        $semesterId = $request->input('semester_id');
        $classGroupId = $request->input('class_group_id');

        if (!$semesterId || !$classGroupId) {
            abort(404, 'Missing required parameters');
        }

        $semesterInfo = Semester::find($semesterId);
        $groupInfo = ClassGroup::with('level')->find($classGroupId);

        if (!$semesterInfo || !$groupInfo) {
            abort(404, 'Data not found');
        }

        $studentsForPdf = Student::query()
            ->where('class_group_id', $classGroupId)
            ->with(['registrations' => function ($q) use ($semesterInfo) {
                $q->where('semester', $semesterInfo->semester)
                  ->where('year', $semesterInfo->year);
            }, 'level', 'classGroup'])
            ->orderBy('student_code')
            ->get();

        $data = [
            'students' => $studentsForPdf,
            'semester' => $semesterInfo,
            'group' => $groupInfo,
            'printDate' => now()->addYears(543)->format('d/m/Y H:i'),
            'isPdf' => true,
        ];

        // Use the same view we created
        $pdf = Pdf::loadView('livewire.pdf.registration-report.report', $data)
            ->setPaper('a4', 'portrait');

        $fileName = 'รายงานการลงทะเบียน_' . $groupInfo->course_group_code . '.pdf';

        return $pdf->stream($fileName);
    }
}
