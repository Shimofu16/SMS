<?php

namespace App\Filament\Registrar\Resources\Students\EnrolleeResource\Pages;

use App\Filament\Registrar\Resources\Students\EnrolleeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnrollees extends ListRecords
{
    protected static string $resource = EnrolleeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    public function getBreadcrumbs(): array
    {
        return [
            'Students',
            'Enrollee',
            'List',
        ];
    }

    public function getTitle(): string
    {
        return 'Enrollees';
    }
}
