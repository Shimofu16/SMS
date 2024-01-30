<?php

namespace App\Filament\Registrar\Resources\Settings\SubjectResource\Pages;

use App\Filament\Registrar\Resources\Settings\SubjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSubjects extends ListRecords
{
    protected static string $resource = SubjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
