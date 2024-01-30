<?php

namespace App\Filament\Teacher\Resources\AdvisoryClassResource\Pages;

use App\Filament\Teacher\Resources\AdvisoryClassResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAdvisoryClasses extends ManageRecords
{
    protected static string $resource = AdvisoryClassResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\Action::make('Download Classlist')
                ->icon('heroicon-o-document-arrow-down')
                ->action(function () {
                    dd('download class list');
                })
        ];
    }
}
