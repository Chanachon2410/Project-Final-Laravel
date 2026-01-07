<?php

namespace App\Providers;

use App\Repositories\ClassGroupRepositoryInterface;
use App\Repositories\CreditFeeRepositoryInterface;
use App\Repositories\Eloquent\ClassGroupRepository;
use App\Repositories\Eloquent\CreditFeeRepository;
use App\Repositories\Eloquent\EloquentRepository;
use App\Repositories\Eloquent\LevelRepository;
use App\Repositories\Eloquent\MajorRepository;
use App\Repositories\Eloquent\RegistrationRepository;
use App\Repositories\Eloquent\SemesterRepository;
use App\Repositories\Eloquent\StudentRepository;
use App\Repositories\Eloquent\StudyPlanRepository;
use App\Repositories\Eloquent\SubjectRepository;
use App\Repositories\Eloquent\TeacherRepository;
use App\Repositories\Eloquent\TuitionFeeRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\EloquentRepositoryInterface;
use App\Repositories\LevelRepositoryInterface;
use App\Repositories\MajorRepositoryInterface;
use App\Repositories\RegistrationRepositoryInterface;
use App\Repositories\SemesterRepositoryInterface;
use App\Repositories\StudentRepositoryInterface;
use App\Repositories\StudyPlanRepositoryInterface;
use App\Repositories\SubjectRepositoryInterface;
use App\Repositories\TeacherRepositoryInterface;
use App\Repositories\TuitionFeeRepositoryInterface;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, EloquentRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LevelRepositoryInterface::class, LevelRepository::class);
        $this->app->bind(StudentRepositoryInterface::class, StudentRepository::class);
        $this->app->bind(TeacherRepositoryInterface::class, TeacherRepository::class);
        $this->app->bind(MajorRepositoryInterface::class, MajorRepository::class);
        $this->app->bind(ClassGroupRepositoryInterface::class, ClassGroupRepository::class);
        $this->app->bind(SubjectRepositoryInterface::class, SubjectRepository::class);
        $this->app->bind(StudyPlanRepositoryInterface::class, StudyPlanRepository::class);
        $this->app->bind(RegistrationRepositoryInterface::class, RegistrationRepository::class);
        $this->app->bind(TuitionFeeRepositoryInterface::class, TuitionFeeRepository::class);
        $this->app->bind(CreditFeeRepositoryInterface::class, CreditFeeRepository::class);
        $this->app->bind(SemesterRepositoryInterface::class, SemesterRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
