<?php

namespace App\Filament\Registrar\Resources\Settings;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Subject;
use Filament\Forms\Get;
use App\Models\Schedule;
use Filament\Forms\Form;
use App\Models\GradeLevel;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use App\Models\Section as ModelsSection;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Registrar\Resources\Settings\ScheduleResource\Pages;
use App\Filament\Registrar\Resources\Settings\ScheduleResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Model;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationGroup = 'School Settings';
    protected static ?string $navigationLabel  = 'Schedules';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Schedule Information')
                    ->schema([
                        Select::make('subject_id')
                            ->label('Subject')
                            ->options(Subject::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('teacher_id')
                            ->label('Teacher')
                            ->options(Teacher::pluck('name', 'id'))
                            ->searchable()
                            ->required(),
                        Select::make('grade_level_id')
                            ->label('Grade Level')
                            ->options(GradeLevel::pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->live()
                            ->required(),
                        Select::make('section_id')
                            ->label('Section')
                            ->options(
                                function (callable $get) {
                                    return ModelsSection::where('grade_level_id', $get('grade_level_id'))
                                        ->pluck('name', 'id');
                                }
                            )
                            ->searchable()
                            ->preload()
                            ->required(),

                    ])
                    ->columns(2),
                Section::make('Classes Information')
                    ->schema([
                        Repeater::make('classes')
                            ->schema([
                                DatePicker::make('date')
                                    ->after(now()->subDay())
                                    ->required(),
                                TimePicker::make('start')
                                    ->seconds(false)
                                    ->required(),
                                TimePicker::make('end')
                                    ->seconds(false)
                                    ->after('start')
                                    ->required(),

                            ])

                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedule::route('/create'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
