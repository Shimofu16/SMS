<?php

namespace App\Filament\Registrar\Resources\Settings;

use App\Filament\Registrar\Resources\Settings\TeacherResource\Pages;
use App\Filament\Registrar\Resources\Settings\TeacherResource\RelationManagers;
use App\Models\Teacher;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TeacherResource extends Resource
{
    protected static ?string $model = Teacher::class;

    protected static ?string $navigationGroup = 'School Settings';
    protected static ?string $navigationLabel  = 'Teachers';

    public static function form(Form $form): Form
    {
        return $form
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
                TextColumn::make('birthday')
                    ->date('F d, Y', 'Asia/Manila'),
                TextColumn::make('phone'),
                TextColumn::make('email'),
                TextColumn::make('address'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTeachers::route('/'),
            // 'create' => Pages\CreateTeacher::route('/create'),
            // 'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }
}
