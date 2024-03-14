<?php

namespace App\Livewire\Pages\Settings;

use Filament\Tables;

use App\Models\Subject;
use App\Models\Teacher;
use Filament\Forms\Set;
use Livewire\Component;
use App\Models\Schedule;
use App\Models\GradeLevel;
use App\Models\ScheduleClass;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Illuminate\Contracts\View\View;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use App\Models\Section as ModelsSection;
use Filament\Infolists\Components\Group;
use Filament\Notifications\Notification;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class ScheduleList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public static function table(Table $table): Table
    {
        $setting = getCurrentSetting();
        return $table
            ->headerActions([
                CreateAction::make()
                    ->button()
                    ->createAnother(false)
                    ->form([
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
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        $subjectName = Subject::find($data['subject_id'])->name;
                        $data['code'] = strtoupper(str_replace(['a', 'e', 'i', 'o', 'u'], '', $subjectName));
                        $data['school_year_id'] = getCurrentSetting()->school_year_id;
                        return $data;
                    })
                    ->using(function (array $data, string $model): Model {
                        $classes = $data['classes'];
                        $schedule = Schedule::create($data);
                        foreach ($classes as $key => $class) {
                            ScheduleClass::create([
                                'schedule_id' => $schedule->id,
                                'date' => $class['date'],
                                'start' => $class['start'],
                                'end' => $class['end'],
                            ]);
                        }

                        return $schedule;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Created')
                            ->body('Schedule has been created successfully.'),
                    ),
            ])
            ->query(
                Schedule::query()
                    ->where('school_year_id', $setting->school_year_id)
                    ->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ])
            )
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
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make()
                    ->infolist(
                        function (Infolist $infolist): Infolist {
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
                    ),
                EditAction::make()
                    ->form([
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
                    ])
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['classes'] = ScheduleClass::where('schedule_id', $data['id'])->get()->toArray();

                        return $data;
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        $subjectName = Subject::find($data['subject_id'])->name;
                        $data['code'] = strtoupper(str_replace(['a', 'e', 'i', 'o', 'u'], '', $subjectName));

                        return $data;
                    })
                    ->using(function (Model $record, array $data): Model {
                        $classes = $data['classes'];
                        foreach ($classes as $key => $class) {
                            ScheduleClass::find($class['id'])->update([
                                'date' => $class['date'],
                                'start' => $class['start'],
                                'end' => $class['end'],
                            ]);
                        }
                        $record->update($data);

                        return $record;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Updated')
                            ->body('Schedule has been updated successfully.'),
                    ),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
    public function render(): View
    {
        return view('livewire.pages.settings.schedule-list');
    }
}
