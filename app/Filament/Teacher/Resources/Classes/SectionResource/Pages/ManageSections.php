<?php

namespace App\Filament\Teacher\Resources\Classes\SectionResource\Pages;

use App\Filament\Teacher\Resources\Classes\SectionResource;
use App\Models\Section;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageSections extends ManageRecords
{
    protected static string $resource = SectionResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }



    public function getTitle(): string
    {
        $section = Section::where('teacher_id', Auth::user()->teacher_id)
            ->first();
        $title = 'No Advisory Class';
        if ($section) {
            $title = 'Advisory Class - ' . $section->name;
        }
        return $title;
    }
}
