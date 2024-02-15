<?php

namespace App\Filament\Admin\Resources\Settings\SchoolYearResource\Pages;

use App\Filament\Admin\Resources\Settings\SchoolYearResource;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSchoolYears extends ManageRecords
{
    protected static string $resource = SchoolYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->mutateFormDataUsing(function (array $data): array {
                    $start =  Carbon::parse($data['start_date'])->format('Y');
                    $end = Carbon::parse($data['end_date'])->format('Y');
                    $data['slug'] = "$start-$end";

                    return $data;
                }),
        ];
    }
}
