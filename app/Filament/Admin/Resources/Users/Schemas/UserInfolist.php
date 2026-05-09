<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use App\Filament\Schemas\Components\AdditionalInformation;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Jeffersongoncalves\FilamentFlux\Infolists\Components\FluxIconEntry;
use Jeffersongoncalves\FilamentFlux\Infolists\Components\FluxTextEntry;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns()
                    ->schema([
                        FluxTextEntry::make('id'),
                        FluxIconEntry::make('status')
                            ->fluxIcon(fn ($state): string => $state ? 'check-badge' : 'x-mark')
                            ->fluxColor(fn ($state): string => $state ? 'green' : 'red'),
                        FluxTextEntry::make('name'),
                        FluxTextEntry::make('email'),
                    ]),
                AdditionalInformation::make([
                    'created_at',
                    'updated_at',
                ]),
            ]);
    }
}
