<?php

namespace App\Filament\Teacher\Resources\Classes;

use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use App\Filament\Teacher\Resources\Classes\SectionResource\Pages;
use App\Filament\Teacher\Resources\Classes\SectionResource\RelationManagers;
use App\Models\StudentEnrollment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SectionResource extends Resource
{

    protected static ?string $model = StudentEnrollment::class;
    // protected static ?string $model = Section::class;
    protected static ?string $navigationGroup = 'Classes';
    protected static ?string $navigationLabel  = 'Section';

    public static function getEloquentQuery(): Builder
    {
        $setting = getCurrentSetting();
        return parent::getEloquentQuery()
            ->whereHas('section', function ($query) {
                $query->where('teacher_id', Auth::user()->teacher_id);
            })

            ->where('school_year_id', $setting->school_year_id)
            ->whereJsonContains('payments->status', StudentEnrollmentPaymentStatus::PAID->value)
            ->where('status', StudentEnrollmentStatusEnum::ACCEPTED->value)
            ->join('students', 'students.id', '=', 'student_enrollments.student_id')
            ->orderBy('students.gender', 'ASC');
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.full_name')
                    ->searchable(),
                TextColumn::make('student.gender')
                    ->searchable(),
            ])
            ->emptyStateHeading('No section yet');
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSections::route('/'),
        ];
    }
}
