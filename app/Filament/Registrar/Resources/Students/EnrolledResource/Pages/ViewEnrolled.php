<?php

namespace App\Filament\Registrar\Resources\Students\EnrolledResource\Pages;

use App\Filament\Registrar\Resources\Students\EnrolledResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEnrolled extends ViewRecord
{
    protected static string $resource = EnrolledResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
