<?php

namespace App\Livewire\Pages\Backend\Students;

use App\Enums\DocumentTypeEnum;
use App\Enums\StudentEnrollmentPaymentStatus;
use App\Enums\StudentEnrollmentStatusEnum;
use App\Models\GradeLevel;
use App\Models\Student;
use Carbon\Carbon;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

#[Layout('layouts.app')]
class EnrolleeStudentList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public static function table(Table $table): Table
    {
        $setting = getCurrentSetting();
        return $table
            ->query(
                Student::query()->with('enrollments')
                    ->whereHas('enrollments', function ($query) use ($setting) {
                        $query
                            ->where('school_year_id', $setting->school_year_id)
                            ->whereJsonContains('payments->status', StudentEnrollmentPaymentStatus::PENDING->value)
                            ->where('status', StudentEnrollmentStatusEnum::PENDING->value);
                    })
            )
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name'),
                TextColumn::make('email')
                    ->icon('heroicon-o-envelope'),
                TextColumn::make('gender'),
                TextColumn::make('age'),
                TextColumn::make('enrollment.gradeLevel.name')
                    ->label('Grade Level'),

            ])
            ->filters([
                Filter::make('declined')
                    ->query(fn (Builder $query) => $query->whereHas('enrollments', function ($query) {
                        $query->where('status', StudentEnrollmentStatusEnum::DECLINED->value);
                    }))
                    ->label('Declined students'),
                SelectFilter::make('grade_level')
                    ->options(GradeLevel::all()->pluck('name', 'id'))
                    ->query(fn (Builder $query, array $data) => $query->whereHas('enrollments', function ($query) use ($data) {
                        if ($data['value']) {
                            $query->where('grade_level_id', $data['value']);
                        }
                    }))
            ])
            ->actions([
                ViewAction::make()
                    ->infolist(
                        function (Infolist $infolist): Infolist {
                            return $infolist
                                ->schema([
                                    Tabs::make('Tabs')
                                        ->tabs([
                                            Tabs\Tab::make('Student Information')
                                                ->schema([
                                                    ImageEntry::make('photo')
                                                        ->getStateUsing(fn (Student $record): string => $record->photo_url)
                                                        ->circular()
                                                        ->columnSpan(2),
                                                    TextEntry::make('lrn')
                                                        ->label('Learner`s Reference Number')
                                                        ->columnSpan(2),
                                                    TextEntry::make('full_name'),
                                                    TextEntry::make('gender'),
                                                    TextEntry::make('age'),
                                                    TextEntry::make('birthday')
                                                        ->getStateUsing(function (Student $record) {
                                                            return date('F j, Y', strtotime($record->birthday));
                                                        }),
                                                    TextEntry::make('address')
                                                        ->columnSpanFull(),
                                                    TextEntry::make('enrollment.gradeLevel.name')
                                                        ->label('Grade Level'),
                                                    TextEntry::make('enrollment.student_type')
                                                        ->label('Enrollment Type'),
                                                ])
                                                ->columns(4),
                                            Tabs\Tab::make('Family Information')
                                                ->schema([
                                                    Section::make('Father')
                                                        ->schema([
                                                            TextEntry::make('father.name')
                                                                ->label('Name'),
                                                            TextEntry::make('father.birthday')
                                                                ->getStateUsing(fn ($record) => date('F j, Y', strtotime($record->father->birthday)))
                                                                ->label('Birthday'),
                                                            TextEntry::make('father.age')
                                                                ->getStateUsing(fn ($record) => Carbon::parse($record->father->birthday)->age)
                                                                ->label('Age'),
                                                            TextEntry::make('father.occupation')
                                                                ->label('Occupation'),
                                                            TextEntry::make('father.phone')
                                                                ->label('Phone'),
                                                        ])->columns(3),
                                                    Section::make('Mother')
                                                        ->schema([
                                                            TextEntry::make('mother.name')
                                                                ->label('Name'),
                                                            TextEntry::make('mother.birthday')
                                                                ->getStateUsing(fn ($record) => date('F j, Y', strtotime($record->mother->birthday)))
                                                                ->label('Birthday'),
                                                            TextEntry::make('mother.age')
                                                                ->getStateUsing(fn ($record) => Carbon::parse($record->mother->birthday)->age)
                                                                ->label('Age'),
                                                            TextEntry::make('mother.occupation')
                                                                ->label('Occupation'),

                                                            TextEntry::make('mother.phone')
                                                                ->label('Phone'),

                                                        ])->columns(3),
                                                ])
                                                ->extraAttributes([
                                                    'style' => 'padding: 0;',
                                                ]),
                                            Tabs\Tab::make('Enrollment Information')
                                                ->schema([
                                                    TextEntry::make('enrollment.gradeLevel.name')
                                                        ->label('Grade Level'),
                                                    TextEntry::make('enrollment.schoolYear.slug')
                                                        ->label('School Year'),
                                                    TextEntry::make('enrollment.student_type')
                                                        ->label('Enrollment Type'),
                                                    TextEntry::make('enrollment.department')
                                                        ->label('Department'),
                                                    Fieldset::make('Documents')
                                                        ->schema([
                                                            IconEntry::make('photo')
                                                                ->getStateUsing(function (Student $record) {
                                                                    return $record->enrollment->hasDocument(DocumentTypeEnum::PHOTO->value);
                                                                })
                                                                ->label('Photo')
                                                                ->boolean(),
                                                            IconEntry::make('form_138')
                                                                ->getStateUsing(function (Student $record) {
                                                                    return $record->enrollment->hasDocument(DocumentTypeEnum::FORM_138->value);
                                                                })
                                                                ->label('Form 138')
                                                                ->boolean(),
                                                            IconEntry::make('birth_certificate')
                                                                ->getStateUsing(function (Student $record) {
                                                                    return $record->enrollment->hasDocument(DocumentTypeEnum::BIRTH_CERTIFICATE->value);
                                                                })
                                                                ->label('Birth Certificate')
                                                                ->boolean(),
                                                            IconEntry::make('good_moral_certification ')
                                                                ->getStateUsing(function (Student $record) {
                                                                    return $record->enrollment->hasDocument(DocumentTypeEnum::GOOD_MORAL_CERTIFICATION->value);
                                                                })
                                                                ->label('Good Moral Certification ')
                                                                ->boolean(),
                                                        ])
                                                        ->columnSpanFull(),
                                                ])
                                                ->columns(4)
                                                ->extraAttributes([
                                                    'style' => 'padding: .5rem;',
                                                ]),
                                            Tabs\Tab::make('Payments Information')
                                                ->schema([
                                                    // KeyValueEntry::make('payments')
                                                    TextEntry::make('payment_method')
                                                        ->getStateUsing(function (Student $record) {
                                                            return $record->enrollment->payments['payment_method'];
                                                        }),
                                                    TextEntry::make('mode_of_payment')
                                                        ->getStateUsing(function (Student $record) {
                                                            return $record->enrollment->payments['mode_of_payment'];
                                                        }),
                                                    TextEntry::make('amount')
                                                        ->getStateUsing(function (Student $record) {
                                                            return $record->enrollment->payments['amount'];
                                                        })
                                                        ->money('PHP'),
                                                    TextEntry::make('status')
                                                        ->getStateUsing(function (Student $record) {
                                                            return $record->enrollment->payments['status'];
                                                        }),
                                                    ImageEntry::make('proof_of_payment')
                                                        ->getStateUsing(function (Student $record) {
                                                            return $record->enrollment->payments['proof_of_payment'];
                                                        })
                                                        ->height(400)
                                                        ->width(400)
                                                        ->columnSpanFull()
                                                        ->hidden(function (Student $record) {
                                                            return $record->enrollment->payments['proof_of_payment'] == null;
                                                        }),
                                                ])
                                                ->columns(4)
                                                ->extraAttributes([
                                                    'style' => 'padding: .5rem;',
                                                ]),
                                        ])
                                        ->columnSpanFull(),

                                ]);
                        }
                    )
                    ->label('More Information'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('accept')
                        // ->fillForm(fn (Collection $records): array => [
                        //     'section_id' => $records[],
                        // ])
                        // ->form([
                        //     Select::make('section_id')
                        //         ->label('Section')
                        //         ->options(Section::query()->pluck('name', 'id'))
                        //         ->required(),
                        // ])
                        ->icon('heroicon-m-check-circle')
                        ->label('Accept Students')
                        ->color(Color::Green)
                        ->requiresConfirmation()
                        ->modalDescription('Are you sure you want to accept the selected students?')
                        ->action(function (Collection $records) {
                            // count the successfully enrolled students
                            $count = 0;
                            $setting = getCurrentSetting();
                            foreach ($records as $record) {
                                $section =  getSectionWithCapacityNotFull($record->enrollment->grade_level_id);

                                if ($section) {
                                    if (count($section->schedules) > 0) {
                                        // Update status within the payments array
                                        $payments = json_encode($record->enrollment->updatePayment(StudentEnrollmentPaymentStatus::PAID->value));
                                        // Update enrollment status and section_id
                                        $record
                                            ->enrollment
                                            ->update([
                                                'status' => StudentEnrollmentStatusEnum::ACCEPTED->value,
                                                'payments' => json_decode($payments, true),
                                                'section_id' => $section->id,
                                            ]);

                                        foreach ($section->schedules as $key => $schedule) {
                                            // create grade
                                            $record->grades()->create([
                                                'schedule_id' => $schedule->id,
                                                'grade_level_id' => $record->enrollment->grade_level_id,
                                                'school_year_id' => $setting->school_year_id,
                                                'grades' => [
                                                    'first' => 0,
                                                    'second' => 0,
                                                    'third' => 0,
                                                    'fourth' => 0,
                                                ]
                                            ]);
                                        }
                                        if (!$record->user) {
                                            $record->user()->create([
                                                'name' => $record->full_name,
                                                'email' => $record->email,
                                                'email_verified_at' => now(),
                                                'password' => Hash::make('password123'),
                                                'role_id' => 4
                                            ]);
                                        }
                                        $count++;
                                    } else {
                                        Notification::make()
                                            ->title('Section has no schedules')
                                            ->body("Section $section->name  doesn`t have schedule. Please add schedule first")
                                            ->danger()
                                            ->send();
                                    }
                                } else {
                                    Notification::make()
                                        ->title('Section Full')
                                        ->body("Section $section->name  is Full")
                                        ->danger()
                                        ->send();
                                }
                            }
                            if ($count > 0) {
                                Notification::make()
                                    ->title('Successfully Accepted Students')
                                    ->body("Successfully accepted $count students and assigned them to their specified sections")
                                    ->success()
                                    ->send();
                            }
                            if (countStudentsWithStatus(StudentEnrollmentStatusEnum::PENDING->value) == 0) {
                                return redirect(route('students.enrolled.index'));
                            }
                            return redirect(route('students.enrollee.index'));
                        }),
                    BulkAction::make('decline')
                        ->icon('heroicon-m-x-circle')
                        ->label('Decline Students')
                        ->color(Color::Red)
                        ->requiresConfirmation()
                        ->modalDescription('Are you sure you want to decline the selected students?')
                        ->action(function (Collection $records) {
                            foreach ($records as $record) {
                                $record
                                    ->enrollment
                                    ->update([
                                        'status' => StudentEnrollmentStatusEnum::DECLINED->value,
                                    ]);
                                Notification::make()
                                    ->title('Declined ' . $record->full_name)
                                    ->body('Declined ' . $record->full_name)
                                    ->danger()
                                    ->send();
                            }
                            return redirect(route('students.enrollee.index'));
                        })
                        ->disabled(function () {
                            $count = countStudentsWithStatus(StudentEnrollmentStatusEnum::DECLINED->value);
                            return $count > 0;
                        }),

                ]),
            ]);
    }
    public function render(): View
    {
        return view('livewire.pages.backend.students.enrollee-student-list');
    }
}
