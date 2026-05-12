<?php

namespace App\Filament\Resources\Transactions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use App\Models\Item;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // TextInput::make('user_id')
                //     ->required()
                //     ->numeric(),
                Hidden::make('user_id')->default(auth()->id()),
                Hidden::make('date')->default(now())->required(),
                Section::make('Payment')
                    ->schema([
                        TextInput::make('pay_total')->prefix('Rp. ')->numeric()->inlinelabel(),
                        TextInput::make('change')->prefix('Rp. ')->numeric()->disabled()->inlinelabel(),
                    ]),

                Section::make('Cart')
                    ->schema([
                        Repeater::make('item_list')
                            ->schema([
                                Select::make('item_id')->label('Item')
                                ->options(Item::pluck('name', 'id'))
                                ->required()
                                ->reactive(),
                                TextInput::make('qty')->numeric()->default(1),
                                TextInput::make('Subtotal')->prefix('Rp. ')->numeric()->disabled(),
                            ])->columns(3)->addActionLabel('Add Item'),
                            TextInput::make('total')->prefix('Rp. ')->numeric()->readonly()->inlineLabel(),
                    ]),



                // TextInput::make('total')
                //     ->required()
                //     ->numeric(),
                // TextInput::make('pay_total')
                //     ->required()
                //     ->numeric(),
            ]);
    }
}
