<?php

namespace App\Filament\Registrar\Resources\Students;

use App\Enums\DocumentTypeEnum;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Infolists\Components\Tabs;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\StudentEnrollmentStatusEnum;
use Filament\Infolists\Components\TextEntry;
use App\Enums\StudentEnrollmentPaymentStatus;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists\Components\Section as InfoListSection;
use App\Filament\Registrar\Resources\Students\EnrolledResource\Pages;
use App\Filament\Registrar\Resources\Students\EnrolledResource\RelationManagers;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Infolist;

class EnrolledResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationGroup = 'Students';
    protected static ?string $navigationLabel  = 'Enrolled';


    // badge
    public static function getNavigationBadge(): ?string
    {
        $setting = getCurrentSetting();
        return static::getModel()::with('enrollments')
            ->whereHas('enrollments', function ($query) use ($setting) {
                $query
                    ->where('school_year_id', $setting->school_year_id)
                    ->whereJsonContains('payments->status', StudentEnrollmentPaymentStatus::PAID->value)
                    ->where('status', StudentEnrollmentStatusEnum::ACCEPTED->value);
            })
            ->count();
    }


    public static function getEloquentQuery(): Builder
    {
        $setting = getCurrentSetting();
        return parent::getEloquentQuery()->with('enrollments')
            ->whereHas('enrollments', function ($query) use ($setting) {
                $query
                    ->where('school_year_id', $setting->school_year_id)
                    ->whereJsonContains('payments->status', StudentEnrollmentPaymentStatus::PAID->value)
                    ->where('status', StudentEnrollmentStatusEnum::ACCEPTED->value);
            });
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label('Name'),
                TextColumn::make('email')
                    ->icon('heroicon-o-envelope'),
                TextColumn::make('gender'),
                TextColumn::make('age'),
                TextColumn::make('enrollment.gradeLevel.name')
                    ->label('Grade Level'),
                TextColumn::make('enrollment.section.name')
                    ->label('Section'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
    public static function infolist(Infolist $infolist): Infolist
    {
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
                                InfoListSection::make('Father')
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
                                        TextEntry::make('father.address')
                                            ->label('Address')
                                            ->columnSpanFull(),
                                        RepeatableEntry::make('father.contacts')
                                            ->schema([
                                                TextEntry::make('contact')
                                                    ->inlineLabel(),
                                                TextEntry::make('type')
                                                    ->inlineLabel(),
                                            ])
                                            ->label('Contacts')

                                            ->columnSpanFull(),
                                    ])->columns(4),
                                InfoListSection::make('Mother')
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
                                        TextEntry::make('mother.address')
                                            ->label('Address')
                                            ->columnSpanFull(),
                                        RepeatableEntry::make('mother.contacts')
                                            ->schema([
                                                TextEntry::make('contact')
                                                    ->inlineLabel(),
                                                TextEntry::make('type')
                                                    ->inlineLabel(),
                                            ])
                                            ->label('Contacts')

                                            ->columnSpanFull(),
                                    ])->columns(4),
                            ])
                            ->extraAttributes([
                                'style' => 'padding: 0;',
                            ]),
                        Tabs\Tab::make('Guardian Information')
                            ->schema([
                                TextEntry::make('guardian.name')
                                    ->label('Name'),
                                TextEntry::make('guardian.birthday')
                                    ->getStateUsing(fn ($record) => date('F j, Y', strtotime($record->guardian->birthday)))
                                    ->label('Birthday'),
                                TextEntry::make('guardian.age')
                                    ->getStateUsing(fn ($record) => Carbon::parse($record->guardian->birthday)->age)
                                    ->label('Age'),
                                TextEntry::make('guardian.occupation')
                                    ->label('Occupation'),
                                TextEntry::make('guardian.address')
                                    ->label('Address')
                                    ->columnSpanFull(),
                                RepeatableEntry::make('guardian.contacts')
                                    ->schema([
                                        TextEntry::make('contact')
                                            ->inlineLabel(),
                                        TextEntry::make('type')
                                            ->inlineLabel(),
                                    ])
                                    ->label('Contacts')
                                    ->columnSpanFull(),
                            ])
                            ->columns(4),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnrolleds::route('/'),
            // 'create' => Pages\CreateEnrolled::route('/create'),
            // 'view' => Pages\ViewEnrolled::route('/{record}'),
            'edit' => Pages\EditEnrolled::route('/{record}/edit'),
        ];
    }
}
