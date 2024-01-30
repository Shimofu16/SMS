<?php

namespace App\Filament\Registrar\Resources\Settings\ScheduleResource\Pages;

use App\Filament\Registrar\Resources\Settings\ScheduleResource;
use App\Models\Schedule;
use App\Models\ScheduleClass;
use App\Models\Subject;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSchedule extends CreateRecord
{
    protected static string $resource = ScheduleResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $subjectName = Subject::find($data['subject_id'])->name;
        $data['code'] = strtoupper(str_replace(['a', 'e', 'i', 'o', 'u'], '', $subjectName));
        $data['school_year_id'] = getCurrentSetting()->school_year_id;
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $classes = $data['classes'];
        $schedule = static::getModel()::create($data);
        foreach ($classes as $key => $class) {
            ScheduleClass::create([
                'schedule_id' => $schedule->id,
                'date' => $class['date'],
                'start' => $class['start'],
                'end' => $class['end'],
            ]);
        }
        return $schedule;
    }
}
