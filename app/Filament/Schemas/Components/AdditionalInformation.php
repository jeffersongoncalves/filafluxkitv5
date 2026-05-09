<?php

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Components\Section;
use Jeffersongoncalves\FilamentFlux\Infolists\Components\FluxTextEntry;

class AdditionalInformation
{
    public static function make(array $dates = ['created_at', 'updated_at'])
    {
        $dates = collect($dates)
            ->map(fn ($date) => FluxTextEntry::make($date)
                ->formatStateUsing(fn ($state) => $state?->format('d/m/Y H:i')))
            ->toArray();

        return Section::make(__('ADDITIONAL INFORMATION'))
            ->description(__('Information on the date of registration and date of modification.'))
            ->columns()
            ->schema($dates);
    }
}
