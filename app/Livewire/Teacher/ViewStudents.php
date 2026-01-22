<?php

namespace App\Livewire\Teacher;

use App\Models\Semester;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ViewStudents extends Component
{
    public $classGroups;
    public $activeSemester;
    public $selectedGroupId; // Selected group from URL
    
    // For Modal
    public $isShowProofModalOpen = false;
    public $selectedRegistration = null;
    public $selectedStudent = null;

    public function mount($groupId = null)
    {
        $this->selectedGroupId = $groupId;
        $this->activeSemester = Semester::where('is_active', true)->first();
        $this->loadData();
    }

    public function loadData()
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();

        if ($teacher) {
            // Fetch Class Groups that this teacher advises
            $query = $teacher->advisedClassGroups()
                ->with(['level', 'students' => function ($query) {
                    $query->orderBy('student_code', 'asc')
                          ->with(['registrations' => function ($rQuery) {
                                if ($this->activeSemester) {
                                    $rQuery->where('semester', $this->activeSemester->semester)
                                          ->where('year', $this->activeSemester->year);
                                }
                          }]);
                }]);
            
            if ($this->selectedGroupId) {
                $query->where('id', $this->selectedGroupId);
            }

            $this->classGroups = $query->get();
        } else {
            $this->classGroups = collect();
        }
    }

    public function viewProof($studentId)
    {
        $this->selectedStudent = \App\Models\Student::with(['registrations' => function ($query) {
            if ($this->activeSemester) {
                $query->where('semester', $this->activeSemester->semester)
                      ->where('year', $this->activeSemester->year);
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
        $registration = \App\Models\Registration::find($registrationId);
        $teacher = Teacher::where('user_id', Auth::id())->first();

        if ($registration && $teacher) {
            $approverName = $teacher->title . $teacher->firstname . ' ' . $teacher->lastname;
            
            $registration->update([
                'status' => 'approved',
                'approved_by' => $approverName
            ]);
            
            // Refresh data
            $this->loadData();
            
            // Close modal if open (optional)
            $this->isShowProofModalOpen = false;
        }
    }

    public function updateStatus($registrationId, $status, $studentId = null)
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();
        if (!$teacher) return;
        
        $approverName = $teacher->title . $teacher->firstname . ' ' . $teacher->lastname;

        if ($registrationId) {
            // Update existing registration
            $registration = \App\Models\Registration::find($registrationId);
            if ($registration) {
                $data = ['status' => $status];
                
                if ($status === 'approved') {
                     $data['approved_by'] = $approverName;
                } elseif ($status === 'pending' || $status === 'rejected') {
                     $data['approved_by'] = null;
                }

                $registration->update($data);
            }
        } elseif ($studentId && $this->activeSemester) {
            // Create NEW registration (Manual by teacher)
            $data = [
                'student_id' => $studentId,
                'semester' => $this->activeSemester->semester,
                'year' => $this->activeSemester->year,
                'status' => $status,
                'registration_card_file' => null, // Allowed by nullable
                'slip_file_name' => null,       // Allowed by nullable
            ];

             if ($status === 'approved') {
                 $data['approved_by'] = $approverName;
            }

            \App\Models\Registration::create($data);
        }
        
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.teacher.view-students');
    }
}
