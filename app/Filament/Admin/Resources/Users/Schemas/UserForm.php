<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Jeffersongoncalves\FilamentFlux\Forms\Components\FluxInput;
use Jeffersongoncalves\FilamentFlux\Forms\Components\FluxSwitch;

use function filled;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->columns()
                    ->schema([
                        FluxSwitch::make('status')
                            ->required()
                            ->autofocus(),
                        FluxInput::make('name')
                            ->required()
                            ->string()
                            ->autofocus(),
                        FluxInput::make('email')
                            ->required()
                            ->string()
                            ->unique('users', 'email', ignoreRecord: true)
                            ->email()
                            ->fluxIcon('envelope'),
                        FluxInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->rule('min:6')
                            ->fluxIcon('lock-closed'),
                    ]),
            ]);
    }
}
