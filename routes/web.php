<?php


use Illuminate\Support\Facades\Route;
use App\Livewire\Forms\EnrollmentForm;
use App\Livewire\Pages\Dashboard\DashboardPanel;
use App\Livewire\Pages\Payments\AnnualFeeList;
use App\Livewire\Pages\Settings\SectionList;
use App\Livewire\Pages\Settings\SubjectList;
use App\Livewire\Pages\Settings\TeacherList;
use App\Livewire\Pages\Settings\ScheduleList;
use App\Livewire\Pages\Settings\SchoolYearList;
use App\Livewire\Pages\Settings\AnnouncementList;
use App\Livewire\Pages\Settings\GeneralSettingList;
use App\Livewire\Pages\Students\EnrolledStudentList;
use App\Livewire\Pages\Students\EnrolleeStudentList;

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

Route::get('/', EnrollmentForm::class)->name('enrollment-form');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardPanel::class)->name('dashboard');

    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/enrolled/list', EnrolledStudentList::class)->name('enrolled.index');
        Route::get('/enrollee/list', EnrolleeStudentList::class)->name('enrollee.index');
    });
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::prefix('fees')->name('fees.')->group(function () {
            Route::get('/list', AnnualFeeList::class)->name('index');
        });
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::prefix('announcements')->name('announcements.')->group(function () {
            Route::get('/list', AnnouncementList::class)->name('index');
        });
        Route::prefix('subjects')->name('subjects.')->group(function () {
            Route::get('/list', SubjectList::class)->name('index');
        });
        Route::prefix('sections')->name('sections.')->group(function () {
            Route::get('/list', SectionList::class)->name('index');
        });
        Route::prefix('schedules')->name('schedules.')->group(function () {
            Route::get('/list', ScheduleList::class)->name('index');
        });
        Route::prefix('school-years')->name('school-years.')->group(function () {
            Route::get('/list', SchoolYearList::class)->name('index');
        });
        Route::prefix('teachers')->name('teachers.')->group(function () {
            Route::get('/list', TeacherList::class)->name('index');
        });
        Route::prefix('general')->name('general.')->group(function () {
            Route::get('/list', GeneralSettingList::class)->name('index');
        });
    });
});

Route::get('profile', function () {
    return view('livewire.pages.profile.index');
})
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
