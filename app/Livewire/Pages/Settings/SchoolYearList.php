<?php

namespace App\Livewire\Pages\Settings;

use App\Models\SchoolYear;
use Carbon\Carbon;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]

class SchoolYearList extends Component implements HasForms, HasTable
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
                    ])
                    ->mutateFormDataUsing(function (array $data): array {
                        $start =  Carbon::parse($data['start_date'])->format('Y');
                        $end = Carbon::parse($data['end_date'])->format('Y');
                        $data['slug'] = "$start-$end";

                        return $data;
                    })
                    ->using(function (array $data, string $model): Model {
                        return $model::create($data);
                    })
                    ->successNotification(
                        Notification::make()
                            ->success()
                            ->title('Successfully Created')
                            ->body('School Year has been created successfully.'),
                    ),
            ])
            ->query(
                SchoolYear::query()
            )
            ->columns([
                TextColumn::make('slug')
                    ->label('School Year'),
                TextColumn::make('start_date')
                    ->date(),
                TextColumn::make('end_date')
                    ->date(),
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public function render(): View
    {
        return view('livewire.pages.settings.school-year-list');
    }
}
