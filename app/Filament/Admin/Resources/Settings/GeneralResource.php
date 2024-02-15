<?php

namespace App\Filament\Admin\Resources\Settings;

use App\Enums\GradingEnum;
use App\Filament\Admin\Resources\Settings\GeneralResource\Pages;
use App\Filament\Admin\Resources\Settings\GeneralResource\RelationManagers;
use App\Models\SchoolYear;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GeneralResource extends Resource
{
    protected static ?string $model = Setting::class;
    protected static ?string $navigationGroup = 'Settings';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                TextColumn::make('schoolYear.slug'),
                TextColumn::make('current_grading'),
                IconColumn::make('is_grade_editable')
                    ->label('Can edit grades')
                    ->boolean(),
                IconColumn::make('enrollment_status')
                    ->boolean(),
                // IconColumn::make('enrollment_status')
                //     ->icon(fn (string $state): string => match ($state) {
                //         'close' => 'heroicon-o-x-circle',
                //         'active' => 'heroicon-o-check-circle',
                //     })
                //     ->color(fn (string $state): string => match ($state) {
                //         'close' => 'danger',
                //         'active' => 'success',
                //         default => 'gray',
                //     }),
                IconColumn::make('is_current')
                    ->label('Current SY')
                    ->boolean()
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                // ...
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->using(function (Model $record, array $data): Model {
                        if ($data['current_grading'] && $record->current_grading != $data['current_grading'] && isAllStudentsHasGrades()) {
                            $record->update(['current_grading' => $data['current_grading']]);
                            if ($data['current_grading'] == GradingEnum::FOURTH->value) {
                                if ($data['is_current']) {
                                    $setting = getCurrentSetting();
                                    $setting->update(['is_current' => false]);
                                    $record->update(['is_current' => true]);
                                }
                            }
                        }
                        if ($data['is_grade_editable']) {
                            $record->update(['is_grade_editable' => $data['is_grade_editable']]);
                        }
                        if ($data['enrollment_status']) {
                            $record->update(['enrollment_status' => $data['enrollment_status']]);
                        }



                        return $record;
                    }),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGenerals::route('/'),
        ];
    }
}
