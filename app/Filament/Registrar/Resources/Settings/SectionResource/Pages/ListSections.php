<?php

namespace App\Filament\Registrar\Resources\Settings\SectionResource\Pages;

use App\Filament\Registrar\Resources\Settings\SectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSections extends ListRecords
{
    protected static string $resource = SectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
