<?php

namespace App\Filament\Teacher\Resources\Classes\ScheduleResource\Pages;

use App\Filament\Teacher\Resources\Classes\ScheduleResource;
use Filament\Actions;
use App\Models\StudentGrade;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\Summarizers\Average;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ViewStudentGradesTable extends Page implements HasTable
{
    use InteractsWithTable;
    use InteractsWithActions;
    protected static string $resource = ScheduleResource::class;

    protected static string $view = 'filament.teacher.resources.classes.schedule-resource.pages.view-student-grades-table';

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back to Schedules')
                ->action(function () {
                    return redirect($this->getResource()::getUrl('index'));
                }),
            Actions\EditAction::make()
                ->label('Add Grades')
                ->action(function () {
                    $record = static::$resource::getModel()::query()->first();
                    // Access the record here and do something with it, e.g.:
                    return redirect(route('filament.teacher.resources.classes.schedules.edit', $record));
                }),

        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            'Schedules',
            'Grades',
            'List',
        ];
    }

    public function getTitle(): string
    {
        return 'Student Grades';
    }
    public function mount(): void
    {
        static::authorizeResourceAccess();
        // Get the model associated with the resource.
        $model = static::$resource::getModel()::query()->first();
        // dd($model);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                $model = static::$resource::getModel()::query()->first();
                $setting = getCurrentSetting();
                return StudentGrade::query()
                    ->where('school_year_id', $setting->school_year_id)
                    ->where('schedule_id', $model->id);
            })
            ->columns([
                TextColumn::make('student.full_name')
                    ->searchable(),
                TextColumn::make('first_grading')
                    ->getStateUsing(function (StudentGrade $record) {
                        // dd(json_decode($record->grades, true));
                        if ($record->grades['first'] == 0) {
                            return 0;
                        }
                        return $record->grades['first'];
                    }),
                TextColumn::make('second_grading')
                    ->getStateUsing(function (StudentGrade $record) {
                        if ($record->grades['second'] == 0) {
                            return 0;
                        }
                        return $record->grades['second'];
                    }),
                TextColumn::make('third_grading')
                    ->getStateUsing(function (StudentGrade $record) {
                        if ($record->grades['third'] == 0) {
                            return 0;
                        }
                        return $record->grades['third'];
                    }),
                TextColumn::make('fourth_grading')
                    ->getStateUsing(function (StudentGrade $record) {
                        if ($record->grades['fourth'] == 0) {
                            return 0;
                        }
                        return $record->grades['fourth'];
                    }),

                TextColumn::make('final_grade')
                    ->getStateUsing(function (StudentGrade $record) {
                        $average = 0;
                        $total = 0;
                        foreach ($record->grades as $key => $grade) {
                            $total = $total + $grade;
                        }
                        $average = $total / 4;
                        if ($record->grades['fourth'] == 0) {
                            return 0;
                        }
                        return $average;
                    }),
            ])
            ->emptyStateHeading('No Students Grades');
    }
}
