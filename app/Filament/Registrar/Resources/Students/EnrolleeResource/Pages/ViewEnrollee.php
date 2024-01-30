<?php

namespace App\Filament\Registrar\Resources\Students\EnrolleeResource\Pages;

use App\Filament\Registrar\Resources\Students\EnrolleeResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEnrollee extends ViewRecord
{
    protected static string $resource = EnrolleeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
