<?php

namespace App\Livewire\Pages\Settings;

use App\Models\Teacher as ModelsTeacher;
use Filament\Forms\Components\DatePicker;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class TeacherList extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->button()
                    ->createAnother(false)->createAnother(false)
                    ->form([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                DatePicker::make('birthday')
                                    ->before(now()->format('d/m/Y'))
                                    ->required(),
                                TextInput::make('phone')
                                    ->numeric()
                                    ->length(11)
                                    ->required(),
                                TextInput::make('email')
                                    ->email()
                                    ->required(),
                                Textarea::make('address')
                                    ->required()
                            ])
                            ->columns(2)
                    ])
                    ->using(function (array $data, string $model): Model {
                        return $model::create($data);
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Created')
                            ->body('Teacher has been created successfully.'),
                    ),
            ])
            ->query(
                ModelsTeacher::query()
                    ->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ])
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('birthday')
                    ->date('F d, Y', 'Asia/Manila'),
                TextColumn::make('phone'),
                TextColumn::make('email'),
                TextColumn::make('address'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                DatePicker::make('birthday')
                                    ->before(now()->format('d/m/Y'))
                                    ->required(),
                                TextInput::make('phone')
                                    ->numeric()
                                    ->length(11)
                                    ->required(),
                                TextInput::make('email')
                                    ->email()
                                    ->required(),
                                Textarea::make('address')
                                    ->required()
                            ])
                            ->columns(2)
                    ])

                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Updated')
                            ->body('Teacher has been updated successfully.'),
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
        return view('livewire.pages.settings.teacher-list');
    }
}
