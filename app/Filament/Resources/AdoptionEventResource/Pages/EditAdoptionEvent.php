<?php

namespace App\Filament\Resources\AdoptionEventResource\Pages;

use App\Filament\Resources\AdoptionEventResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdoptionEvent extends EditRecord
{
    protected static string $resource = AdoptionEventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
