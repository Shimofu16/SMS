<?php

namespace App\Livewire\EnrollmentForm;

use App\Models\AnnualFee;
use App\Models\Shop\Product;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;

use Livewire\Component;

class PaymentTable extends Component implements  HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public function table(Table $table): Table
    {
        return $table
            ->query(AnnualFee::query())
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('amount'),
            ])
            ->filters([
                // ...
            ])
            ->actions([
                // ...
            ])
            ->bulkActions([
                // ...
            ]);
    }
    public function render(): View
    {
        return view('livewire.enrollment-form.payment-table');
    }
}
