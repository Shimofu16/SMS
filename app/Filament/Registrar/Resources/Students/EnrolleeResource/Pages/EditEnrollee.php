<?php

namespace App\Filament\Registrar\Resources\Students\EnrolleeResource\Pages;

use App\Filament\Registrar\Resources\Students\EnrolleeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnrollee extends EditRecord
{
    protected static string $resource = EnrolleeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
