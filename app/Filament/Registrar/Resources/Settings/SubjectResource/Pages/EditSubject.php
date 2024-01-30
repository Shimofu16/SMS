<?php

namespace App\Filament\Registrar\Resources\Settings\SubjectResource\Pages;

use App\Filament\Registrar\Resources\Settings\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubject extends EditRecord
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
