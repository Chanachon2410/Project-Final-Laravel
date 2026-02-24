<?php

namespace App\Livewire\Teacher;

use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ViewStudents extends Component
{
    use WithPagination;

    public $activeSemester;
    public $semester_id; // Added for semester filtering
    public $selectedGroupId; // Selected group ID
    
    // Filters
    public $search = '';
    public $statusFilter = '';
    public $perPage = 10;
    
    // Modal state
    public $isShowProofModalOpen = false;
    public $isShowFilterModalOpen = false; // Filter modal state
    public $isShowRemarksModalOpen = false;
    public $selectedRegistration = null;
    public $selectedStudent = null;

    // Form properties for status update
    public $remarks = '';
    public $tempStatus = '';
    public $tempRegistrationId = null;
    public $tempStudentId = null;

    public function mount($groupId = null)
    {
        $this->selectedGroupId = $groupId;
        $this->activeSemester = Semester::where('is_active', true)->first();
        if ($this->activeSemester) {
            $this->semester_id = $this->activeSemester->id;
        }
    }

    protected function getTeacher()
    {
        return Teacher::where('user_id', Auth::id())->first();
    }

    public function updatingSemesterId()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingSelectedGroupId()
    {
        $this->resetPage();
    }

    public function viewProof($studentId)
    {
        $selectedSemester = Semester::find($this->semester_id);
        $this->selectedStudent = Student::with(['registrations' => function ($query) use ($selectedSemester) {
            if ($selectedSemester) {
                $query->where('semester', $selectedSemester->semester)
                      ->where('year', $selectedSemester->year);
            }
        }])->find($studentId);

        if ($this->selectedStudent) {
            $this->selectedRegistration = $this->selectedStudent->registrations->first();
            $this->isShowProofModalOpen = true;
        }
    }

    public function closeProofModal()
    {
        $this->isShowProofModalOpen = false;
        $this->selectedRegistration = null;
        $this->selectedStudent = null;
    }

    public function approveRegistration($registrationId)
    {
        $registration = Registration::find($registrationId);
        $teacher = $this->getTeacher();

        if ($registration && $teacher) {
            $approverName = $teacher->title . $teacher->firstname . ' ' . $teacher->lastname;
            
            $registration->update([
                'status' => 'approved',
                'approved_by' => $approverName
            ]);
            
            $this->isShowProofModalOpen = false;
        }
    }

    public function openRemarksModal($registrationId, $status, $studentId = null)
    {
        $this->tempRegistrationId = $registrationId;
        $this->tempStatus = $status;
        $this->tempStudentId = $studentId;
        
        // Pre-fill remarks if editing existing registration
        if ($registrationId) {
            $reg = Registration::find($registrationId);
            $this->remarks = $reg->remarks ?? '';
        } else {
            $this->remarks = '';
        }

        $this->isShowRemarksModalOpen = true;
    }

    public function closeRemarksModal()
    {
        $this->isShowRemarksModalOpen = false;
        $this->remarks = '';
        $this->tempStatus = '';
        $this->tempRegistrationId = null;
        $this->tempStudentId = null;
    }

    public function submitStatusWithRemarks()
    {
        $this->updateStatus($this->tempRegistrationId, $this->tempStatus, $this->tempStudentId, $this->remarks);
        $this->closeRemarksModal();
    }

    public function updateStatus($registrationId, $status, $studentId = null, $remarks = null)
    {
        $teacher = $this->getTeacher();
        if (!$teacher) return;
        
        $approverName = $teacher->title . $teacher->firstname . ' ' . $teacher->lastname;
        $selectedSemester = Semester::find($this->semester_id);

        if ($registrationId) {
            $registration = Registration::find($registrationId);
            if ($registration) {
                $data = ['status' => $status];
                
                if ($remarks !== null) {
                    $data['remarks'] = $remarks;
                }

                if ($status === 'approved') {
                     $data['approved_by'] = $approverName;
                } else {
                     $data['approved_by'] = null;
                }
                $registration->update($data);
                
                // Refresh modal data if open
                if ($this->isShowProofModalOpen && $this->selectedStudent && $this->selectedStudent->id == $registration->student_id) {
                    $this->selectedRegistration = $registration->fresh();
                }
            }
        } elseif ($studentId && $selectedSemester) {
            $data = [
                'student_id' => $studentId,
                'semester' => $selectedSemester->semester,
                'year' => $selectedSemester->year,
                'status' => $status,
                'remarks' => $remarks
            ];
            if ($status === 'approved') {
                 $data['approved_by'] = $approverName;
            }
            Registration::create($data);

            // Refresh student data to show the new registration in the main list
            $this->resetPage();
        }

        $this->dispatch('swal:success', message: 'อัปเดตสถานะการลงทะเบียนเรียบร้อยแล้ว');
    }

    public function render()
    {
        $teacher = $this->getTeacher();
        $advisedGroups = collect();
        $stats = ['total' => 0, 'paid' => 0, 'pending' => 0, 'not_registered' => 0];
        $selectedSemester = Semester::find($this->semester_id);
        
        if ($teacher) {
            $advisedGroups = $teacher->advisedClassGroups()->with('level')->get();
            $advisedGroupIds = $advisedGroups->pluck('id');

            $query = Student::query()
                ->with(['classGroup', 'level', 'registrations' => function ($q) use ($selectedSemester) {
                    if ($selectedSemester) {
                        $q->where('semester', $selectedSemester->semester)
                          ->where('year', $selectedSemester->year);
                    }
                }]);

            if ($this->selectedGroupId) {
                $query->where('class_group_id', $this->selectedGroupId);
            } else {
                $query->whereIn('class_group_id', $advisedGroupIds);
            }

            // Stats Calculation (Before applying status/search filters, but after group filter)
            $statsQuery = clone $query;
            $allMatchingStudents = $statsQuery->get();
            $stats['total'] = $allMatchingStudents->count();
            foreach ($allMatchingStudents as $student) {
                $reg = $student->registrations->first();
                if (!$reg) {
                    $stats['not_registered']++;
                } elseif ($reg->status == 'approved') {
                    $stats['paid']++;
                } elseif ($reg->status == 'pending') {
                    $stats['pending']++;
                } else {
                    $stats['not_registered']++;
                }
            }

            if ($this->search) {
                $query->where(function($q) {
                    $q->where('student_code', 'like', '%' . $this->search . '%')
                      ->orWhere('firstname', 'like', '%' . $this->search . '%')
                      ->orWhere('lastname', 'like', '%' . $this->search . '%');
                });
            }

            if ($this->statusFilter) {
                if ($this->statusFilter === 'unregistered') {
                    $query->whereDoesntHave('registrations', function ($q) use ($selectedSemester) {
                        if ($selectedSemester) {
                            $q->where('semester', $selectedSemester->semester)
                              ->where('year', $selectedSemester->year);
                        }
                    });
                } else {
                    $query->whereHas('registrations', function ($q) use ($selectedSemester) {
                        if ($selectedSemester) {
                            $q->where('semester', $selectedSemester->semester)
                              ->where('year', $selectedSemester->year)
                              ->where('status', $this->statusFilter);
                        }
                    });
                }
            }

            $students = $query->orderBy('student_code', 'asc')->paginate($this->perPage);
        } else {
            $students = Student::where('id', -1)->paginate($this->perPage);
        }

        return view('livewire.teacher.view-students', [
            'students' => $students,
            'advisedGroups' => $advisedGroups,
            'semesters' => Semester::orderBy('year', 'desc')->orderBy('semester', 'desc')->get(),
            'stats' => $stats
        ]);
    }
}