<?php

namespace App\Livewire\Pages\Payments;

use App\Enums\FeeTypeEnum;
use App\Enums\LevelEnum;
use App\Models\AnnualFee;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class AnnualFeeList extends Component implements HasForms, HasTable
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
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('amount')
                                    ->numeric()
                                    ->required(),
                                Select::make('type')
                                    ->options(FeeTypeEnum::toArray())
                                    ->label('Payment Type')
                                    ->required(),
                                Select::make('level')
                                    ->options(LevelEnum::toArray())
                                    ->label('Grade  Levels')
                                    ->required(),


                            ]),

                    ])
                    ->mutateFormDataUsing(function (array $data) use ($setting): array {
                        $data['school_year_id'] = $setting->school_year_id;
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
                AnnualFee::query()
                    ->where('school_year_id', $setting->school_year_id)
                    ->withoutGlobalScopes([
                        SoftDeletingScope::class,
                    ])
            )
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('amount')
                    ->money('PHP'),
                TextColumn::make('type'),
                TextColumn::make('level'),  
            ])
            ->filters([
                TrashedFilter::make(),
                SelectFilter::make('type')
                    ->options(FeeTypeEnum::toArray()),
                SelectFilter::make('level')
                    ->options(LevelEnum::toArray()),
            ])
            ->actions([

                EditAction::make()
                    ->form([
                        Section::make()
                            ->schema([
                                TextInput::make('name')
                                    ->required(),
                                TextInput::make('amount')
                                    ->numeric()
                                    ->required(),
                                Select::make('type')
                                    ->options(FeeTypeEnum::toArray())
                                    ->label('Payment Type')
                                    ->required(),
                                Select::make('level')
                                    ->options(LevelEnum::toArray())
                                    ->label('Grade  Levels')
                                    ->required(),


                            ]),
                    ])
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Updated')
                            ->body('Fee has been updated successfully.'),
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
        return view(
            'livewire.pages.payments.annual-fee-list',
            [
                'setting' => getCurrentSetting()
            ]
        );
    }
}
