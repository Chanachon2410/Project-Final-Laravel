<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Services\FeeCalculationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    protected $feeService;

    public function __construct(FeeCalculationService $feeService)
    {
        $this->feeService = $feeService;
    }

    public function downloadRegistrationForm($registrationId)
    {
        $registration = Registration::with([
            'student.user', 
            'student.level', 
            'student.classGroup.major',
            'student.classGroup.advisor'
        ])->findOrFail($registrationId);

        $student = $registration->student;
        $semester = $registration->semester;
        $year = $registration->year;

        // Calculate Fees
        $feeData = $this->feeService->calculateTotal($student, $semester, $year);
        $thaiBahtText = $this->feeService->getThaiBahtText($feeData['total_amount']);

        // Get Registered Subjects (Study Plan)
        $studyPlans = \App\Models\StudyPlan::where('class_group_id', $student->class_group_id)
            ->where('semester', $semester)
            ->where('year', $year)
            ->with('subject', 'teacher')
            ->get();

        $data = [
            'registration' => $registration,
            'student' => $student,
            'feeData' => $feeData,
            'thaiBahtText' => $thaiBahtText,
            'studyPlans' => $studyPlans,
            'semester' => $semester,
            'year' => $year,
            'date' => now()->format('d/m/Y'), // Thai date format ideally
        ];

        // Generate PDF
        $pdf = Pdf::loadView('pdf.registration-form', $data);
        
        // A4 Paper, Portrait
        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream("registration-{$student->student_code}.pdf");
    }
}