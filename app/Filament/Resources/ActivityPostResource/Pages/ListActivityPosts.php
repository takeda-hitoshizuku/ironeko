<?php

namespace App\Filament\Resources\ActivityPostResource\Pages;

use App\Filament\Resources\ActivityPostResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActivityPosts extends ListRecords
{
    protected static string $resource = ActivityPostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
