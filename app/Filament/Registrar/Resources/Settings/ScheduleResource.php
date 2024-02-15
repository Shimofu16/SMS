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
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Tables\Columns\TextColumn;
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
                                    ->required()
                                    ->columnSpanFull(),
                                TimePicker::make('start')
                                    ->seconds(false)
                                    ->required(),
                                TimePicker::make('end')
                                    ->seconds(false)
                                    ->after('start')
                                    ->required(),

                            ])
                            ->cloneable()
                            ->reorderable(false)
                            ->grid(2)
                            ->columns(2)

                    ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $setting = getCurrentSetting();
        return parent::getEloquentQuery()
            ->where('school_year_id', $setting->school_year_id)
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable(),
                TextColumn::make('subject.name')
                    ->searchable(),
                TextColumn::make('teacher.name')
                    ->searchable(),
                TextColumn::make('gradeLevel.name')
                    ->searchable(),
                TextColumn::make('section.name')
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    // ...
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                RepeatableEntry::make('classes')
                    ->schema([
                        TextEntry::make('date')
                            ->date(),
                        Group::make([
                            TextEntry::make('start')
                                ->time('h:m A'),
                            TextEntry::make('end')
                                ->time('h:m A'),

                        ])
                            ->columns(2)

                    ])
                    ->columnSpanFull(2)
            ]);
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
