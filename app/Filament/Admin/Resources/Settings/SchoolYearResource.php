<?php

namespace App\Filament\Admin\Resources\Settings;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\SchoolYear;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\Settings\SchoolYearResource\Pages;
use App\Filament\Admin\Resources\Settings\SchoolYearResource\RelationManagers;
use Carbon\Carbon;

class SchoolYearResource extends Resource
{
    protected static ?string $model = SchoolYear::class;

    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        DatePicker::make('start_date')
                            ->live(),
                        DatePicker::make('end_date')
                            ->after(now()->format('Y'))
                            ->reactive()
                            ->afterStateUpdated(function (callable $set, callable $get, $state, $context) {
                                $start =  Carbon::parse($get('start_date'))->format('Y');
                                $end = Carbon::parse($state)->format('Y');
                                $set('slug',  "$start-$end");
                            }),
                        TextInput::make('slug')
                            ->required()
                            ->disabled()
                            ->unique(column: 'slug'),

                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('slug')
                    ->label('SY'),
                TextColumn::make('start_date')
                    ->date(),
                TextColumn::make('end_date')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSchoolYears::route('/'),
        ];
    }
}
