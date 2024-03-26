<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Backend\Academics\SectionList;
use App\Livewire\Pages\Backend\Academics\SubjectList;
use App\Livewire\Pages\Backend\Academics\TeacherList;
use App\Livewire\Pages\Backend\Academics\ScheduleList;
use App\Livewire\Pages\Backend\Payments\AnnualFeeList;
use App\Livewire\Pages\Backend\Academics\SchoolYearList;
use App\Livewire\Pages\Backend\AccessControls\UserLists;
use App\Livewire\Pages\Backend\Dashboard\DashboardPanel;
use App\Livewire\Pages\Backend\Academics\AnnouncementList;
use App\Livewire\Pages\Frontend\Enrollment\EnrollmentForm;
use App\Livewire\Pages\Backend\Students\EnrolledStudentList;
use App\Livewire\Pages\Backend\Students\EnrolleeStudentList;
use App\Livewire\Pages\Backend\Academics\EnrollmentSettingList;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/enrollment/form', EnrollmentForm::class)->name('enrollment-form');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardPanel::class)->name('dashboard')->middleware('can:view-dashboard');

    Route::prefix('students')->name('students.')->middleware('can:view-dashboard')->group(function () {
        Route::prefix('enrolled')->name('enrolled.')->middleware(['can:view-enrolled-students', 'can:edit-enrolled-student'])->group(function () {
            Route::get('/list', EnrolledStudentList::class)->name('index');
        });
        Route::prefix('enrollee')->name('enrollee.')->middleware(['can:view-enrollee-students', 'can:edit-enrollee-student'])->group(function () {
            Route::get('/list', EnrolleeStudentList::class)->name('index');
        });
    });
    Route::prefix('payments')->name('payments.')->middleware('can:view-payments')->group(function () {
        Route::prefix('fees')->name('fees.')->middleware(['can:view-fees', 'can:add-fee', 'can:edit-fee', 'can:delete-fee'])->group(function () {
            Route::get('/list', AnnualFeeList::class)->name('index');
        });
    });

    Route::prefix('settings')->name('settings.')->middleware('can:view-settings')->group(function () {
        Route::prefix('announcements')->name('announcements.')->middleware(['can:view-announcements', 'can:add-announcement', 'can:edit-announcement', 'can:delete-announcement'])->group(function () {
            Route::get('/list', AnnouncementList::class)->name('index');
        });
        Route::prefix('enrollment')->name('enrollment.')->middleware(['can:view-enrollment-settings', 'can:add-enrollment-setting', 'can:edit-enrollment-setting', 'can:delete-enrollment-setting'])->group(function () {
            Route::get('/list', EnrollmentSettingList::class)->name('index');
        });

    });
    Route::prefix('academics')->name('academics.')->middleware('can:view-academics')->group(function () {
        Route::prefix('subjects')->name('subjects.')->middleware(['can:view-subjects', 'can:add-subject', 'can:edit-subject', 'can:delete-subject'])->group(function () {
            Route::get('/list', SubjectList::class)->name('index');
        });
        Route::prefix('sections')->name('sections.')->middleware(['can:view-sections', 'can:add-section', 'can:edit-section', 'can:delete-section'])->group(function () {
            Route::get('/list', SectionList::class)->name('index');
        });
        Route::prefix('schedules')->name('schedules.')->middleware(['can:view-schedules', 'can:add-schedule', 'can:edit-schedule', 'can:delete-schedule'])->group(function () {
            Route::get('/list', ScheduleList::class)->name('index');
        });
        Route::prefix('school-years')->name('school-years.')->middleware(['can:view-school-years', 'can:add-school-year', 'can:edit-school-year', 'can:delete-school-year'])->group(function () {
            Route::get('/list', SchoolYearList::class)->name('index');
        });
        Route::prefix('teachers')->name('teachers.')->middleware(['can:view-teachers', 'can:add-teacher', 'can:edit-teacher', 'can:delete-teacher'])->group(function () {
            Route::get('/list', TeacherList::class)->name('index');
        });
        Route::prefix('general')->name('general.')->middleware(['can:view-general', 'can:add-general', 'can:edit-general', 'can:delete-general'])->group(function () {
            Route::get('/list', EnrollmentSettingList::class)->name('index');
        });
    });
    Route::prefix('access-controls')->name('access-controls.')->middleware('can:view-access-controls')->group(function () {
        Route::prefix('users')->name('users.')->middleware(['can:view-users', 'can:add-user', 'can:edit-user', 'can:delete-user'])->group(function () {
            Route::get('/list', UserLists::class)->name('index');
        });

    });
});



Route::get('profile', function () {
    return view('livewire.pages.profile.index');
})
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
