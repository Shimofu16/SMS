<?php

namespace App\Livewire\Pages\Students;

use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use App\Models\Student;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
#[Layout('layouts.app')]
class EnrolledStudentList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        $setting = getCurrentSetting();
        return $table
            ->query(
                Student::query()->with('enrollments')
                    ->whereHas('enrollments', function ($query) use ($setting) {
                        $query
                            ->where('school_year_id', $setting->school_year_id)
                            ->whereJsonContains('payments->status', StudentEnrollmentPaymentStatus::PAID->value)
                            ->where('status', StudentEnrollmentStatusEnum::ACCEPTED->value);
                    })
            )
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name'),
                TextColumn::make('email')
                    ->icon('heroicon-o-envelope'),
                TextColumn::make('gender'),
                TextColumn::make('age'),
                TextColumn::make('enrollment.gradeLevel.name')
                    ->label('Grade Level'),
                TextColumn::make('enrollment.section.name')
                    ->label('Section'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Action::make('edit')
                    ->url(fn (Student $record): string => route('posts.edit', $record))
                    ->openUrlInNewTab(),
            ]);
    }

    public function render(): View
    {
        return view('livewire.pages.students.enrolled-student-list');
    }
}
