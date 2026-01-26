<?php

namespace App\Livewire\Registrar;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Semester;
use App\Models\Level;
use App\Models\ClassGroup;
use App\Models\Student;
use Livewire\Attributes\Layout;
use Barryvdh\DomPDF\Facade\Pdf;

class RegistrationReport extends Component
{
    use WithPagination;

    public $semester_id;
    public $level_id;
    public $class_group_id;
    public $status_filter = ''; // '', 'registered', 'not_registered'
    public $search = '';
    public $perPage = 25;

    // Modal Variables
    public $selectedStudent = null;
    public $selectedRegistration = null;
    public $isShowProofModalOpen = false;

    public function mount()
    {
        $activeSemester = Semester::where('is_active', true)->first();
        if ($activeSemester) {
            $this->semester_id = $activeSemester->id;
        }
    }

    public function updatedLevelId()
    {
        $this->class_group_id = null; // Reset class group when level changes
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function viewProof($studentId)
    {
        $this->selectedStudent = Student::with(['classGroup', 'level'])->find($studentId);
        
        $selectedSemester = Semester::find($this->semester_id);
        if ($this->selectedStudent && $selectedSemester) {
            $this->selectedRegistration = $this->selectedStudent->registrations()
                ->where('semester', $selectedSemester->semester)
                ->where('year', $selectedSemester->year)
                ->first();
        } else {
            $this->selectedRegistration = null;
        }

        $this->isShowProofModalOpen = true;
    }

    public function closeProofModal()
    {
        $this->isShowProofModalOpen = false;
        $this->selectedStudent = null;
        $this->selectedRegistration = null;
    }

    public function printReport()
    {
        if (!$this->semester_id || !$this->class_group_id) {
            return;
        }

        $semesterInfo = Semester::find($this->semester_id);
        $groupInfo = ClassGroup::with('level')->find($this->class_group_id);

        $studentsForPdf = Student::query()
            ->where('class_group_id', $this->class_group_id)
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
        ];

        $pdf = Pdf::loadView('livewire.pdf.registration-report.report', $data)
            ->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'รายงานการลงทะเบียน_' . $groupInfo->course_group_code . '.pdf');
    }

    #[Layout('layouts.app')]
    public function render()
    {
        $selectedSemester = Semester::find($this->semester_id);

        $studentsQuery = Student::query()
            ->when($this->level_id, fn($q) => $q->where('level_id', $this->level_id))
            ->when($this->class_group_id, fn($q) => $q->where('class_group_id', $this->class_group_id))
            ->when($this->search, fn($q) => $q->where(function($sub) {
                $sub->where('firstname', 'like', '%'.$this->search.'%')
                    ->orWhere('lastname', 'like', '%'.$this->search.'%')
                    ->orWhere('student_code', 'like', '%'.$this->search.'%');
            }));

        if ($selectedSemester) {
            if ($this->status_filter === 'registered') {
                $studentsQuery->whereHas('registrations', function ($q) use ($selectedSemester) {
                    $q->where('semester', $selectedSemester->semester)
                      ->where('year', $selectedSemester->year);
                });
            } elseif ($this->status_filter === 'not_registered') {
                $studentsQuery->whereDoesntHave('registrations', function ($q) use ($selectedSemester) {
                    $q->where('semester', $selectedSemester->semester)
                      ->where('year', $selectedSemester->year);
                });
            } elseif ($this->status_filter === 'approved') {
                $studentsQuery->whereHas('registrations', function ($q) use ($selectedSemester) {
                    $q->where('semester', $selectedSemester->semester)
                      ->where('year', $selectedSemester->year)
                      ->where('status', 'approved');
                });
            }
        }

        // Clone Query for Stats Calculation (Before Pagination)
        $statsQuery = clone $studentsQuery;
        
        // We need to fetch all students matching criteria to count statuses
        // (Optimized: Count directly using database logic or fetch collection if needed)
        // Since we need to check relationship conditions, fetching might be easier or using withCount
        $allMatchingStudents = $statsQuery->with(['registrations' => function ($q) use ($selectedSemester) {
            if ($selectedSemester) {
                $q->where('semester', $selectedSemester->semester)
                  ->where('year', $selectedSemester->year);
            }
        }])->get();

        $stats = [
            'total' => $allMatchingStudents->count(),
            'paid' => 0, // In this context, 'approved' usually means paid/complete
            'pending' => 0,
            'not_registered' => 0
        ];

        foreach ($allMatchingStudents as $student) {
            $reg = $student->registrations->first();
            if (!$reg) {
                $stats['not_registered']++;
            } elseif ($reg->status == 'approved') {
                $stats['paid']++;
            } elseif ($reg->status == 'pending') {
                $stats['pending']++;
            } else {
                // rejected or other statuses could count as not registered or separate
                // For now, let's group 'rejected' with 'pending' or 'not_registered' depending on business logic
                // Or simply ignore from paid/pending counts. Let's assume 'rejected' acts like they need to resubmit.
                $stats['not_registered']++; 
            }
        }

        $students = $studentsQuery->with(['classGroup', 'level', 'registrations' => function ($q) use ($selectedSemester) {
            if ($selectedSemester) {
                $q->where('semester', $selectedSemester->semester)
                  ->where('year', $selectedSemester->year);
            }
        }])
        ->orderBy('student_code')
        ->paginate($this->perPage);

        // Get Class Groups for Dropdown (Filtered by Level)
        $classGroups = ClassGroup::query()
            ->when($this->level_id, fn($q) => $q->where('level_id', $this->level_id))
            ->orderBy('course_group_code')
            ->get();

        return view('livewire.registrar.registration-report', [
            'students' => $students,
            'semesters' => Semester::orderBy('year', 'desc')->orderBy('semester', 'desc')->get(),
            'levels' => Level::all(),
            'classGroups' => $classGroups,
            'currentSemester' => $selectedSemester,
            'stats' => $stats
        ]);
    }
}