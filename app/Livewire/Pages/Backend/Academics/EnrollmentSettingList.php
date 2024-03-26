<?php

namespace App\Livewire\Pages\Backend\Academics;

use Livewire\Component;
use App\Enums\GradingEnum;
use App\Models\SchoolYear;
use App\Models\Setting;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;

class EnrollmentSettingList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->button()
                    ->createAnother(false)
                    ->form([
                        Section::make()
                            ->schema([
                                Select::make('school_year_id')
                                    ->label('School Year')
                                    ->options(function () {
                                        $setting = getCurrentSetting();
                                        return SchoolYear::where('id', '!=', $setting->school_year_id)
                                            ->pluck('slug', 'id');
                                    })
                                    ->hiddenOn('edit'),
                                Select::make('current_grading')
                                    ->label('Grading')
                                    ->options(GradingEnum::toArray())
                                    ->hiddenOn('create'),
                                Toggle::make('enrollment_status')
                                    ->hiddenOn('create'),
                                Toggle::make('is_grade_editable')
                                    ->helperText('When enabled, you can edit grades within the current grading period.')
                                    ->hiddenOn('create'),
                                Toggle::make('is_current')
                                    // ->helperText('When enabled, you can edit grades within the current grading period.')
                                    ->hiddenOn('create'),
                            ])
                            ->columns(2)
                    ])
                    // ->mutateFormDataUsing(function (array $data): array {


                    //     return $data;
                    // })
                    ->using(function (array $data, string $model): Model {
                        return $model::create($data);
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Created')
                            ->body('Enrollment Setting has been created successfully.'),
                    ),
            ])
            ->query(
                Setting::query()
                    ->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ])
            )
            ->columns([
                TextColumn::make('schoolYear.slug'),
                TextColumn::make('current_grading'),
                IconColumn::make('is_grade_editable')
                    ->label('Can edit grades')
                    ->boolean(),
                IconColumn::make('enrollment_status')
                    ->boolean(),
                IconColumn::make('is_current')
                    ->label('Current SY')
                    ->boolean()
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        Section::make()
                            ->schema([
                                Select::make('school_year_id')
                                    ->label('School Year')
                                    ->options(function () {
                                        $setting = getCurrentSetting();
                                        return SchoolYear::where('id', '!=', $setting->school_year_id)
                                            ->pluck('slug', 'id');
                                    })
                                    ->hiddenOn('edit'),
                                Select::make('current_grading')
                                    ->label('Grading')
                                    ->options(GradingEnum::toArray())
                                    ->hiddenOn('create'),
                                Toggle::make('enrollment_status')
                                    ->hiddenOn('create'),
                                Toggle::make('is_grade_editable')
                                    ->helperText('When enabled, you can edit grades within the current grading period.')
                                    ->hiddenOn('create'),
                                Toggle::make('is_current')
                                    // ->helperText('When enabled, you can edit grades within the current grading period.')
                                    ->hiddenOn('create'),
                            ])
                            ->columns(2)
                    ])
                    ->using(function (Model $record, array $data): Model {
                        $setting = getCurrentSetting();
                        if ($setting->id == $record->id && $data['is_current']) {
                            if ($data['is_grade_editable']) {
                                $record->update(['is_grade_editable' => $data['is_grade_editable']]);
                            }
                            if ($data['enrollment_status']) {
                                $record->update(['enrollment_status' => $data['enrollment_status']]);
                            }
                        }
                        if ($data['current_grading'] && $record->current_grading != $data['current_grading'] && isAllStudentsHasGrades()) {
                            $record->update(['current_grading' => $data['current_grading']]);
                            if ($data['current_grading'] == GradingEnum::FOURTH->value) {
                                if ($data['is_current']) {
                                    $setting->update(['is_current' => false]);
                                    $record->update(['is_current' => true]);
                                }
                            }
                        }


                        return $record;
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Updated')
                            ->body('Enrollment Settings has been updated successfully.'),
                    ),
                DeleteAction::make(),
                ForceDeleteAction::make(),
                RestoreAction::make(),
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
        return view('livewire.pages.settings.enrollment-setting-list');
    }
}
