<?php

namespace App\Filament\Resources\ActivityPostResource\Pages;

use App\Filament\Resources\ActivityPostResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActivityPost extends EditRecord
{
    protected static string $resource = ActivityPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
