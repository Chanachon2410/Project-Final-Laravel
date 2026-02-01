<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PdfController;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Registrar\ApproveRegistrations;
use App\Livewire\Registrar\ManageClassGroups;
use App\Livewire\Registrar\ManageMajors;
use App\Livewire\Registrar\ManageSemesters;
use App\Livewire\Registrar\ManageSubjects;
use App\Livewire\Registrar\ManageTuitionFees;
use App\Livewire\Registrar\RegistrationDocumentForm;
use App\Livewire\Registrar\RegistrationDocumentList;
use App\Livewire\Student\RegistrationUpload;
use App\Livewire\Student\RegistrationForm;
use App\Livewire\Teacher\ViewStudents;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user->hasRole('Admin')) {
        return redirect()->route('admin.users.index');
    } elseif ($user->hasRole('Teacher')) {
        return redirect()->route('teacher.students.view');
    } elseif ($user->hasRole('Registrar')) {
        return redirect()->route('registrar.students.index');
    } elseif ($user->hasRole('Student')) {
        return redirect()->route('student.registration.form');
    }
    return redirect()->route('profile.edit'); // Fallback to profile setting if no specific role dashboard
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', \App\Livewire\UserProfile::class)->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pdf/download/registration/{registrationId}', [PdfController::class, 'downloadRegistrationForm'])->name('pdf.download.registration');

    // Admin Routes
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return redirect()->route('admin.users.index');
        })->name('dashboard');

        Route::get('/users', UserManagement::class)->name('users.index');
    });

    // Teacher Routes
    Route::middleware(['role:Teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/students/{groupId?}', ViewStudents::class)->name('students.view');
        Route::get('/registration-report/preview', [App\Http\Controllers\RegistrationReportPdfController::class, 'preview'])->name('registration-report.preview');
    });

    // Registrar Routes
    Route::middleware(['role:Registrar'])->prefix('registrar')->name('registrar.')->group(function () {
        Route::get('/registration-report/preview', [App\Http\Controllers\RegistrationReportPdfController::class, 'preview'])->name('registration-report.preview');
        Route::get('/import-data', \App\Livewire\Registrar\ImportData::class)->name('import-data.index');

        Route::get('/majors', ManageMajors::class)->name('majors.index');
        Route::get('/subjects', ManageSubjects::class)->name('subjects.index');
        Route::get('/class-groups', ManageClassGroups::class)->name('class-groups.index');
        Route::get('/teachers-info', \App\Livewire\Registrar\TeacherInfo::class)->name('teachers-info.index');
        Route::get('/registrars', \App\Livewire\Registrar\ManageRegistrars::class)->name('registrars.index');
        Route::get('/semesters', ManageSemesters::class)->name('semesters.index');
        Route::get('/tuition-fees', ManageTuitionFees::class)->name('tuition-fees.index');
        Route::get('/registration-documents', RegistrationDocumentList::class)->name('registration-documents.index');
        Route::get('/registration-documents/create', RegistrationDocumentForm::class)->name('registration-documents.create');
        Route::get('/registration-documents/{document}/edit', RegistrationDocumentForm::class)->name('registration-documents.edit');
        Route::get('/students/{student}', \App\Livewire\Registrar\ViewStudent::class)->name('students.view');
        Route::get('/students', \App\Livewire\Registrar\ManageStudents::class)->name('students.index');
        Route::get('/registration-status', \App\Livewire\Registrar\RegistrationStatus::class)->name('registration-status.index');
        Route::get('/registration-report', \App\Livewire\Registrar\RegistrationReport::class)->name('registration-report.index');
    });

    // Student Routes
    Route::middleware(['role:Student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/registration-document/{documentId}/preview', [App\Http\Controllers\RegistrationDocumentPdfController::class, 'preview'])->name('pdf.preview');
        Route::get('/registration/form', RegistrationForm::class)->name('registration.form'); // หน้าเลือกเอกสารลงทะเบียน/Preview
        Route::get('/registration/upload', RegistrationUpload::class)->name('registration.upload');
    });
});

// Handle 403 Forbidden
// Route::fallback(function () {
//     abort(403);
// });

require __DIR__.'/auth.php';