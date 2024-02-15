<?php

namespace App\Filament\Teacher\Resources\Classes\ScheduleResource\Pages;

use App\Filament\Teacher\Resources\Classes\ScheduleResource;
use App\Models\Schedule;
use App\Models\Section;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSchedule extends EditRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Back to Grades'),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            'Schedules',
            'Add',
            'Grades',
        ];
    }

    public function getTitle(): string
    {
        return 'Add Grades';
    }

    private function createArrayValue($schedule_id, $grade_id, $student, $grade = '')
    {
        return [
            'id' => $grade_id,
            'schedule_id' => $schedule_id,
            'student_id' => $student->id,
            'student' => $student->full_name,
            'grade' => $grade
        ];
    }

    private function updateGrade($grades, $grading, $grade)
    {
        $data = [];
        foreach ($grades as $key => $value) {
            if ($key == $grading) {
                $data[$key] = $grade;
            } else {
                $data[$key] = $value;
            }
        }
        return $data;
    }
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $schedule = Schedule::find($data['id']);
        $first_grading_grades = array();
        $second_grading_grades = array();
        $third_grading_grades = array();
        $fourth_grading_grades = array();

        foreach ($schedule->grades as $key => $grade) {
            foreach ($grade['grades'] as $key => $value) {
                if ($key == 'first') {
                    $first_grading_grades[] = $this->createArrayValue($schedule->id, $grade->id, $grade->student, $value);
                }
                if ($key == 'second') {
                    $second_grading_grades[] = $this->createArrayValue($schedule->id, $grade->id, $grade->student, $value);
                }
                if ($key == 'third') {
                    $third_grading_grades[] = $this->createArrayValue($schedule->id, $grade->id, $grade->student, $value);
                }
                if ($key == 'fourth') {
                    $fourth_grading_grades[] = $this->createArrayValue($schedule->id, $grade->id, $grade->student, $value);
                }
            }
        }

        $data['first_grading_grades'] = $first_grading_grades;
        $data['second_grading_grades'] = $second_grading_grades;
        $data['third_grading_grades'] = $third_grading_grades;
        $data['fourth_grading_grades'] = $fourth_grading_grades;
        // dd($data,$section->studentEnrollments);

        return $data;
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        // dd($data);
        return $data;
    }


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $setting = getCurrentSetting();

        // dd($record, $data);
        switch ($setting->current_grading) {
            case 'first':
                foreach ($data['first_grading_grades'] as $key => $first_grading_grade) {
                    $grade = $record->grades()->find($first_grading_grade['id']);
                    $data = $this->updateGrade($grade->grades, 'first', $first_grading_grade['grade']);
                    $grade->update([
                        'grades' => $data
                    ]);
                }
                break;
        }
        return $record;
    }
    protected function beforeSave(): void
    {
        $setting = getCurrentSetting();
        if (!$setting->is_grade_editable) {
            Notification::make()
                ->warning()
                ->title('Access Denied')
                ->body('You don\'t have permission to add/update grades')
                ->persistent()
                ->send();

            $this->halt();
        }
    }
}
