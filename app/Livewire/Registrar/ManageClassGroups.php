<?php

namespace App\Livewire\Registrar;

use App\Repositories\ClassGroupRepositoryInterface;
use App\Repositories\LevelRepositoryInterface;
use App\Repositories\MajorRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClassGroupsImport;
use Illuminate\Support\Facades\Storage;

#[Layout('layouts.app')]
class ManageClassGroups extends Component
{
    use WithPagination, WithFileUploads;

    public $isOpen = false;
    public $isImportModalOpen = false;
    public $importFile;
    public $importErrors = []; // Store import errors
    public $previewData = [];
    public $fileHeaders = [];
    public
    $showPreview = false;
    public $tempFilePath;

    public $classGroupId, $course_group_code, $course_group_name, $level_id, $level_year, $major_id, $teacher_advisor_id;
    public $levels, $majors, $teachers;

    protected $rules = [
        'course_group_code' => 'required|string|max:20',
        'course_group_name' => 'required|string|max:20',
        'level_id' => 'required|integer|exists:levels,id',
        'level_year' => 'required|integer',
        'major_id' => 'required|integer|exists:majors,id',
        'teacher_advisor_id' => 'nullable|integer|exists:teachers,id',
    ];

    private ClassGroupRepositoryInterface $classGroupRepository;
    private LevelRepositoryInterface $levelRepository;
    private MajorRepositoryInterface $majorRepository;
    private TeacherRepositoryInterface $teacherRepository;

    public function boot(
        ClassGroupRepositoryInterface $classGroupRepository,
        LevelRepositoryInterface $levelRepository,
        MajorRepositoryInterface $majorRepository,
        TeacherRepositoryInterface $teacherRepository
    ) {
        $this->classGroupRepository = $classGroupRepository;
        $this->levelRepository = $levelRepository;
        $this->majorRepository = $majorRepository;
        $this->teacherRepository = $teacherRepository;
    }

    public function mount()
    {
        $this->levels = $this->levelRepository->all();
        $this->majors = $this->majorRepository->all();
        $this->teachers = $this->teacherRepository->all();
    }

    public function render()
    {
        return view('livewire.registrar.manage-class-groups', [
            'classGroups' => $this->classGroupRepository->paginate(10, ['*'], ['level', 'major', 'advisor']),
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function edit($id)
    {
        $classGroup = $this->classGroupRepository->findById($id);
        $this->classGroupId = $id;
        $this->course_group_code = $classGroup->course_group_code;
        $this->course_group_name = $classGroup->course_group_name;
        $this->level_id = $classGroup->level_id;
        $this->level_year = $classGroup->level_year;
        $this->major_id = $classGroup->major_id;
        $this->teacher_advisor_id = $classGroup->teacher_advisor_id;
        $this->openModal();
    }

    public function store()
    {
        $this->validate();

        $data = [
            'course_group_code' => $this->course_group_code,
            'course_group_name' => $this->course_group_name,
            'level_id' => $this->level_id,
            'level_year' => $this->level_year,
            'major_id' => $this->major_id,
            'teacher_advisor_id' => $this->teacher_advisor_id,
        ];

        if ($this->classGroupId) {
            $this->classGroupRepository->update($this->classGroupId, $data);
            $this->dispatch('swal:success', message: 'Class Group updated successfully.');
        } else {
            $this->classGroupRepository->create($data);
            $this->dispatch('swal:success', message: 'Class Group created successfully.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        $this->dispatch('swal:confirm', id: $id, message: 'Are you sure you want to delete this class group?');
    }

    #[On('delete-confirmed')]
    public function confirmDelete($classGroupId)
    {
        $this->classGroupRepository->deleteById($classGroupId);
        $this->dispatch('swal:success', message: 'Class Group deleted successfully.');
    }

    private function resetInputFields()
    {
        $this->classGroupId = null;
        $this->course_group_code = '';
        $this->course_group_name = '';
        $this->level_id = '';
        $this->level_year = '';
        $this->major_id = '';
        $this->teacher_advisor_id = '';
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function openImportModal()
    {
        $this->isImportModalOpen = true;
    }

    public function closeImportModal()
    {
        $this->isImportModalOpen = false;
        $this->importErrors = [];
        $this->cancelPreview(); // Reset preview state
    }

    public function previewData()
    {
        $this->validate([
            'importFile' => 'required|mimes:xlsx,xls',
        ]);

        $this->importErrors = [];
        $this->previewData = [];

        try {
            $this->tempFilePath = $this->importFile->store('livewire-tmp');
            $rows = Excel::toCollection(new \stdClass(), $this->tempFilePath)->first();

            if ($rows->isEmpty()) {
                $this->dispatch('swal:error', message: 'The Excel file is empty.');
                return;
            }

            $lastPotentialCode = null;

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 1;
                $val0 = trim($row[0] ?? '');
                $val1 = trim($row[1] ?? '');
                $val2 = trim($row[2] ?? '');
                $colsToCheck = [$val0, $val1, $val2];

                // 1. Find Group Code (9-11 digits)
                $foundCodeThisRow = false;
                foreach ($colsToCheck as $val) {
                    if (preg_match('/^\d{9,11}$/', $val)) {
                        $lastPotentialCode = $val;
                        $foundCodeThisRow = true;
                        break;
                    }
                }
                if ($foundCodeThisRow) continue; // Found code, move to next row to find name

                // 2. Find Group Name
                $foundName = null;
                foreach ($colsToCheck as $val) {
                    if (preg_match('/(ปวช|ปวส)\.(\d+)/', $val)) {
                        $foundName = $val;
                        break;
                    }
                }
                
                // 3. If we have a name and a stored code, we have a pair
                if ($foundName && $lastPotentialCode) {
                    // Parse the name to get details
                    $levelName = '';
                    $classRoom = '-';

                    if (preg_match('/(ปวช|ปวส)\.(\d+)(\/(\d+))?/', $foundName, $matches)) {
                        $prefix = $matches[1];
                        $year = $matches[2];
                        $room = $matches[4] ?? null;
                        $levelName = "{$prefix}.{$year}";
                        $classRoom = $room ?? '-';
                    }

                    // Add to preview data instead of saving
                    $this->previewData[] = [
                        'course_group_code' => $lastPotentialCode,
                        'course_group_name' => $foundName,
                        'level_name'        => $levelName,
                        'class_room'        => $classRoom,
                    ];

                    $lastPotentialCode = null; // Reset after pairing
                }
            }

            if (empty($this->previewData)) {
                 $this->dispatch('swal:warning', message: 'Could not find any valid Class Group pairs to preview.');
            }

            $this->showPreview = true;

        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Error processing file: ' . $e->getMessage());
        }
    }


    public function cancelPreview()
    {
        $this->showPreview = false;
        $this->previewData = [];
        $this->fileHeaders = [];
        if ($this->tempFilePath && Storage::exists($this->tempFilePath)) {
            Storage::delete($this->tempFilePath);
        }
        $this->tempFilePath = null;
        $this->importFile = null;
    }

    public function confirmImport()
    {
        $this->importErrors = []; // Reset errors

        if (!$this->tempFilePath || !Storage::exists($this->tempFilePath)) {
            $this->dispatch('swal:error', message: 'File not found. Please upload again.');
            $this->cancelPreview();
            return;
        }

        try {
            $importer = new ClassGroupsImport;
            Excel::import($importer, $this->tempFilePath);
            
            $this->importErrors = $importer->getErrors();

            if (count($this->importErrors) > 0) {
                $this->dispatch('swal:warning', message: 'Import completed with some issues. Please check the list.');
            } else {
                $this->dispatch('swal:success', message: 'Class Groups imported successfully.');
                $this->closeImportModal();
            }
        } catch (\Exception $e) {
            $this->dispatch('swal:error', message: 'Error importing file: ' . $e->getMessage());
        } finally {
            if ($this->tempFilePath && Storage::exists($this->tempFilePath)) {
                Storage::delete($this->tempFilePath);
            }
        }
    }
}