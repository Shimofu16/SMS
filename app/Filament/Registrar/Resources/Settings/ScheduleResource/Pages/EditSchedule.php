<?php

namespace App\Filament\Registrar\Resources\Settings\ScheduleResource\Pages;

use App\Filament\Registrar\Resources\Settings\ScheduleResource;
use App\Models\ScheduleClass;
use App\Models\Subject;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditSchedule extends EditRecord
{
    protected static string $resource = ScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['classes'] = ScheduleClass::where('schedule_id', $data['id'])->get()->toArray();


        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $subjectName = Subject::find($data['subject_id'])->name;
        $data['code'] = strtoupper(str_replace(['a', 'e', 'i', 'o', 'u'], '', $subjectName));

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $classes = $data['classes'];
        foreach ($classes as $key => $class) {
            ScheduleClass::find($class['id'])->update([
                'date' => $class['date'],
                'start' => $class['start'],
                'end' => $class['end'],
            ]);
        }
        $record->update($data);


        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
