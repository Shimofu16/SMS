<?php

namespace App\Livewire\Pages\Backend\Academics;

use App\Models\GradeLevel;
use App\Models\Section as SectionModel;
use App\Models\Teacher;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\EditAction;
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
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class SectionList extends Component implements HasForms, HasTable
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
                            ->body('Secion has been created successfully.'),
                    ),
            ])
            ->query(
                SectionModel::query()
                ->orderBy('grade_level_id', 'ASC')

            )
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
                EditAction::make()
                    ->form([
                        Section::make()
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
                            ])
                            ->columns(2)
                    ])

                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Updated')
                            ->body('Section has been updated successfully.'),
                    ),
            ])
;
    }
    public function render()
    {
        return view('livewire.pages.backend.academic-settings.section-list');
    }
}
