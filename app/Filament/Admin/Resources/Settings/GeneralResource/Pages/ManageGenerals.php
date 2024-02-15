<?php

namespace App\Filament\Admin\Resources\Settings\GeneralResource\Pages;

use App\Filament\Admin\Resources\Settings\GeneralResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageGenerals extends ManageRecords
{
    protected static string $resource = GeneralResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
