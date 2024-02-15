<?php

namespace App\Filament\Student\Resources;

use App\Filament\Student\Resources\GradeResource\Pages;
use App\Filament\Student\Resources\GradeResource\RelationManagers;
use App\Models\Grade;
use App\Models\GradeLevel;
use App\Models\StudentGrade;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class GradeResource extends Resource
{
    protected static ?string $model = StudentGrade::class;

    protected static ?string $navigationLabel = 'Grades';

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    public static function getEloquentQuery(): Builder
    {
        $setting = getCurrentSetting();
        return parent::getEloquentQuery()
            ->where('school_year_id', $setting->school_year_id)
            ->where('grade_level_id', Auth::user()->student->enrollment->grade_level_id)
            ->where('student_id', Auth::user()->student->id);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_grading')
                    ->getStateUsing(function (StudentGrade $record) {
                        // dd(json_decode($record->grades, true));
                        if ($record->grades['first'] == 0) {
                            return 0;
                        }
                        return $record->grades['first'];
                    }),
                TextColumn::make('second_grading')
                    ->getStateUsing(function (StudentGrade $record) {
                        if ($record->grades['second'] == 0) {
                            return 0;
                        }
                        return $record->grades['second'];
                    }),
                TextColumn::make('third_grading')
                    ->getStateUsing(function (StudentGrade $record) {
                        if ($record->grades['third'] == 0) {
                            return 0;
                        }
                        return $record->grades['third'];
                    }),
                TextColumn::make('fourth_grading')
                    ->getStateUsing(function (StudentGrade $record) {
                        if ($record->grades['fourth'] == 0) {
                            return 0;
                        }
                        return $record->grades['fourth'];
                    }),

                TextColumn::make('final_grade')
                    ->getStateUsing(function (StudentGrade $record) {
                        $average = 0;
                        $total = 0;
                        foreach ($record->grades as $key => $grade) {
                            $total = $total + $grade;
                        }
                        $average = $total / 4;
                        if ($record->grades['fourth'] == 0) {
                            return 0;
                        }
                        return $average;
                    }),
            ])
            ->filters([
                SelectFilter::make('grade_level')
                    ->options(GradeLevel::query()->pluck('name', 'id'))
                    ->searchable()
                    ->attribute('grade_level_id')

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGrades::route('/'),
        ];
    }
}
