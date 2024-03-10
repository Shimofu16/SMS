<?php

namespace App\Livewire\Pages\Settings;

use App\Models\Subject;
use Livewire\Component;
use Filament\Tables\Table;

use Filament\Forms\Components\Section;
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
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]

class SubjectList extends Component implements HasForms, HasTable
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
                                ->autocapitalize('words')
                                ->columnSpanFull()
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
                            ->body('Subject has been created successfully.'),
                    ),
            ])
            ->query(
                Subject::query()
                    ->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ])
            )
            ->columns([
                TextColumn::make('name')
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
                                ->autocapitalize('words')
                                ->columnSpanFull()
                                ->required(),
                            ])
                            ->columns(2)
                    ])

                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Updated')
                            ->body('Subject has been updated successfully.'),
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
        return view('livewire.pages.settings.subject-list');
    }
}
