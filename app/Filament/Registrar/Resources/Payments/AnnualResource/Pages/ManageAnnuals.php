<?php

namespace App\Filament\Registrar\Resources\Payments\AnnualResource\Pages;

use App\Filament\Registrar\Resources\Payments\AnnualResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAnnuals extends ManageRecords
{
    protected static string $resource = AnnualResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    
}
