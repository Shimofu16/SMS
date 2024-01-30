<?php

namespace App\Filament\Registrar\Resources\Students\EnrolledResource\Pages;

use App\Filament\Registrar\Resources\Students\EnrolledResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnrolleds extends ListRecords
{
    protected static string $resource = EnrolledResource::class;

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
            'Enrolled',
            'List',
        ];
    }

    public function getTitle(): string
    {
        return 'Enrolled';
    }
}
