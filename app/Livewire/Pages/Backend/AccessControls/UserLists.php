<?php

namespace App\Livewire\Pages\Backend\AccessControls;

use App\Enums\RoleEnum;
use App\Enums\UserStatusEnum;
use App\Models\User;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Table;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UserLists extends Component implements HasForms, HasTable
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
                            TextInput::make('email')
                                ->email()
                                ->required(),
                            TextInput::make('password')
                                ->password()
                                ->revealable()
                                ->required(),
                            Select::make('roles')
                                ->options(RoleEnum::toArray(['administrator', 'student']))
                                ->multiple()
                                ->required(),


                        ]),

                ])
                ->mutateFormDataUsing(function (array $data): array {

                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Successfully Created')
                        ->body('Fee has been created successfully.'),
                ),
        ])
            ->query(
                User::whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'administrator');
                })

            )
            ->filters([
                SelectFilter::make('status')
                    ->options(UserStatusEnum::toArray())
                    ->multiple(),

            ])
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email'),
                TextColumn::make('roles.name'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'inactive' => 'warning',
                        'active' => 'success',
                        'deactivated' => 'danger',
                    }),
                ToggleColumn::make('is_force_to_password_change')
                    ->label('Force to change password')
            ])
            ->actions([])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('force_to_change_password')
                    ->color(Color::Red)
                    ->requiresConfirmation(),
                ])
            ]);
    }
    public function render()
    {
        return view('livewire.pages.backend.access-controls.user-lists');
    }
}
