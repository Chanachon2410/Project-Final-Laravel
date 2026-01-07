<?php

namespace App\Livewire\Registrar;

use App\Repositories\ClassGroupRepositoryInterface;
use App\Repositories\LevelRepositoryInterface;
use App\Repositories\MajorRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
class ManageClassGroups extends Component
{
    use WithPagination;

    public $isOpen = false;
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
}
