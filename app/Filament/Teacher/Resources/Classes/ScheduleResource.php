<?php

namespace App\Filament\Teacher\Resources\Classes;

use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use Filament\Forms;
use Filament\Tables;
use App\Models\Schedule;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\StudentGrade;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use App\Models\Section as ModelsSection;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\Group;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Teacher\Resources\Classes\ScheduleResource\Pages;
use App\Filament\Teacher\Resources\Classes\ScheduleResource\RelationManagers;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Infolists\Components\Split;

class ScheduleResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationGroup = 'Classes';
    public static $setting;

    public function __construct()
    {
        $this->setting = getCurrentSetting();
    }

    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Section::make(function ($record) {
                    return "Section: {$record->section->name}";
                })
                    ->schema([
                        Tabs::make('Tabs')
                            ->tabs([
                                Tabs\Tab::make('First Grading')
                                    ->schema([
                                        Repeater::make('first_grading_grades')
                                            ->label('Student - Grade')
                                            ->schema([
                                                Hidden::make('schedule_id'),
                                                Hidden::make('student_id'),
                                                TextInput::make('student')
                                                    ->label('')
                                                    ->disabled(),
                                                TextInput::make('grade')
                                                    ->label('')
                                                    ->placeholder('Final Grade')
                                                    ->numeric()
                                                    ->required(function () {
                                                        $setting = getCurrentSetting();
                                                        return  $setting->current_grading == 'first';
                                                    }),
                                            ])
                                            ->reorderableWithDragAndDrop(false)
                                            ->reorderable(false)
                                            ->deletable(false)
                                            ->addable(false)
                                            ->columns(2)
                                            ->columnSpanFull()
                                    ])
                                    ->disabled(function () {
                                        $setting = getCurrentSetting();
                                        return !($setting->current_grading == 'first' && $setting->is_grade_editable);
                                    })
                                    ->columnSpanFull(),
                                Tabs\Tab::make('Second Grading')
                                    ->schema([
                                        Repeater::make('second_grading_grades')
                                            ->label('Student - Grade')
                                            ->schema([
                                                Hidden::make('schedule_id'),
                                                Hidden::make('student_id'),
                                                TextInput::make('student')
                                                    ->label('')
                                                    ->disabled(),
                                                TextInput::make('grade')
                                                    ->label('')
                                                    ->placeholder('Final Grade')
                                                    ->numeric()
                                                    ->required(function () {
                                                        $setting = getCurrentSetting();
                                                        return  $setting->current_grading == 'second';
                                                    }),
                                            ])
                                            ->reorderableWithDragAndDrop(false)
                                            ->reorderable(false)
                                            ->deletable(false)
                                            ->addable(false)
                                            ->columns(2)
                                            ->columnSpanFull()
                                    ])
                                    ->disabled(function () {
                                        $setting = getCurrentSetting();
                                        return !($setting->current_grading == 'second' && $setting->is_grade_editable);
                                    })
                                    ->columnSpanFull(),
                                Tabs\Tab::make('Third Grading')
                                    ->schema([
                                        Repeater::make('third_grading_grades')
                                            ->label('Student - Grade')
                                            ->schema([
                                                Hidden::make('schedule_id'),
                                                Hidden::make('student_id'),
                                                TextInput::make('student')
                                                    ->label('')
                                                    ->disabled(),
                                                TextInput::make('grade')
                                                    ->label('')
                                                    ->placeholder('Final Grade')
                                                    ->numeric()
                                                    ->required(function () {
                                                        $setting = getCurrentSetting();
                                                        return  $setting->current_grading == 'third';
                                                    }),
                                            ])
                                            ->reorderableWithDragAndDrop(false)
                                            ->reorderable(false)
                                            ->deletable(false)
                                            ->addable(false)
                                            ->columns(2)
                                            ->columnSpanFull()
                                    ])
                                    ->disabled(function () {
                                        $setting = getCurrentSetting();
                                        return !($setting->current_grading == 'third' && $setting->is_grade_editable);
                                    })
                                    ->columnSpanFull(),
                                Tabs\Tab::make('Fourth Grading')
                                    ->schema([
                                        Repeater::make('fourth_grading_grades')
                                            ->label('Student - Grade')
                                            ->schema([
                                                Hidden::make('schedule_id'),
                                                Hidden::make('student_id'),
                                                TextInput::make('student')
                                                    ->label('')
                                                    ->disabled(),
                                                TextInput::make('grade')
                                                    ->label('')
                                                    ->placeholder('Final Grade')
                                                    ->numeric()
                                                    ->required(function () {
                                                        $setting = getCurrentSetting();
                                                        return  $setting->current_grading == 'fourth';
                                                    }),
                                            ])
                                            ->reorderableWithDragAndDrop(false)
                                            ->reorderable(false)
                                            ->deletable(false)
                                            ->addable(false)
                                            ->columns(2)
                                            ->columnSpanFull()
                                    ])
                                    ->disabled(function () {
                                        $setting = getCurrentSetting();
                                        return !($setting->current_grading == 'fourth' && $setting->is_grade_editable);
                                    })
                                    ->columnSpanFull(),

                            ])
                            ->activeTab(function () {
                                $setting = getCurrentSetting();
                                switch ($setting->current_grading) {
                                    case 'first':
                                        return 1;
                                        break;
                                    case 'second':
                                        return 2;
                                        break;
                                    case 'third':
                                        return 3;
                                        break;
                                    case 'fourth':
                                        return 4;
                                        break;

                                    default:
                                        return 1;
                                        break;
                                }
                            })
                            ->contained(false)
                    ])
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        $setting = getCurrentSetting();
        return parent::getEloquentQuery()
            ->where('school_year_id', $setting->school_year_id)
            ->where('teacher_id', Auth::user()->teacher_id);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject.name')
                    ->searchable(),
                TextColumn::make('section.name')
                    ->searchable(),
                TextColumn::make('gradeLevel.name')
                    ->searchable(),
                TextColumn::make('students')
                    ->getStateUsing(function ($record) {
                        $setting = getCurrentSetting();
                        return $record->section->withCount('studentEnrollments')
                            ->whereHas('studentEnrollments', function ($query) use ($setting) {
                                $query->where('school_year_id', $setting->school_year_id)
                                    ->whereJsonContains('payments->status', StudentEnrollmentPaymentStatus::PAID->value)
                                    ->where('status', StudentEnrollmentStatusEnum::ACCEPTED->value);
                            })
                            ->first()
                            ->student_enrollments_count;
                    })
                    ->label('Students'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make('grades')
                    ->label('Grades'),
                // ->infolist([
                //     Split::make([
                //         RepeatableEntry::make('grades')
                //             ->schema([
                //                 TextEntry::make('first_grading')
                //                     ->getStateUsing(function ($record) {

                //                         dd($record);
                //                     }),

                //             ]),
                //         Section::make([
                //             //    EditAction
                //         ]),
                //     ])->from('md')

                // ]),
                Tables\Actions\Action::make('schedule')
                    ->icon('heroicon-o-eye')
                    ->modalSubmitAction(false)
                    ->infolist([
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
                    ]),
            ])
            // ->emptyStateIcon('heroicon-o-bookmark')
            ->emptyStateHeading('No schedules yet');
    }

    // public static function infolist(Infolist $infolist): Infolist
    // {
    //     return $infolist
    //         ->schema([
    //             Split::make([
    //                 Section::make([
    //                     TextEntry::make('title'),
    //                     TextEntry::make('content')
    //                         ->markdown()
    //                         ->prose(),
    //                 ]),
    //                 Section::make([
    //                     TextEntry::make('created_at')
    //                         ->dateTime(),
    //                     TextEntry::make('published_at')
    //                         ->dateTime(),
    //                 ]),
    //             ])
    //         ]);
    // }

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
            'view' => Pages\ViewStudentGradesTable::route('/{record}'),
            'edit' => Pages\EditSchedule::route('/{record}/edit'),
        ];
    }
}
