<?php

namespace App\Filament\Registrar\Resources\Settings;

use App\Filament\Registrar\Resources\Settings\SectionResource\Pages;
use App\Filament\Registrar\Resources\Settings\SectionResource\RelationManagers;
use App\Models\GradeLevel;
use App\Models\Section;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionResource extends Resource
{
    protected static ?string $model = Section::class;
    protected static ?string $navigationGroup = 'School Settings';
    protected static ?string $navigationLabel  = 'Sections';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('capacity')
                    ->numeric()
                    ->helperText('No. of students allowed')
                    ->required(),
                Select::make('teacher_id')
                    ->label('Home Room Teacher')
                    ->options(Teacher::query()->pluck('name', 'id'))
                    ->required(),
                Select::make('grade_level_id')
                    ->label('Grade Level')
                    ->options(GradeLevel::query()->pluck('name', 'id'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('capacity')
                    ->label('No. of students allowed'),
                TextColumn::make('student_enrollments_count')
                    ->label('Students')
                    ->counts('studentEnrollments'),
                TextColumn::make('teacher.name'),
                TextColumn::make('gradeLevel.name'),
            ])
            ->filters([
                SelectFilter::make('grade_level_id')
                    ->label('Grade Level')
                    ->options(GradeLevel::query()->pluck('name', 'id')),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSections::route('/'),
            // 'create' => Pages\CreateSection::route('/create'),
            // 'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}
