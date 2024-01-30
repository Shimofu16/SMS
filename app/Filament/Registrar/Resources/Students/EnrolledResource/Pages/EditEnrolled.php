<?php

namespace App\Filament\Registrar\Resources\Students\EnrolledResource\Pages;

use App\Filament\Registrar\Resources\Students\EnrolledResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnrolled extends EditRecord
{
    protected static string $resource = EnrolledResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
