<?php

namespace App\Filament\Registrar\Resources\Students\EnrolledResource\Pages;

use App\Filament\Registrar\Resources\Students\EnrolledResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEnrolled extends CreateRecord
{
    protected static string $resource = EnrolledResource::class;
}
