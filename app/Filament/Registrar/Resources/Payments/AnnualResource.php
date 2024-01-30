<?php

namespace App\Filament\Registrar\Resources\Payments;

use App\Enums\FeeTypeEnum;
use App\Enums\LevelEnum;
use App\Filament\Registrar\Resources\Payments\AnnualResource\Pages;
use App\Filament\Registrar\Resources\Payments\AnnualResource\RelationManagers;
use App\Models\AnnualFee;
use App\Models\SchoolYear;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnnualResource extends Resource
{
    protected static ?string $model = AnnualFee::class;
    protected static ?string $navigationGroup = 'Payments';
    protected static ?string $navigationLabel  = 'Annual Fees';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Payment')
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
                    ])
                    ->columns(2)
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('amount')
                    ->money('PHP'),
                TextColumn::make('type'),
                TextColumn::make('level'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                SelectFilter::make('type')
                    ->options(FeeTypeEnum::toArray()),
                SelectFilter::make('level')
                    ->options(LevelEnum::toArray()),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    // ...
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageAnnuals::route('/'),
        ];
    }
}
