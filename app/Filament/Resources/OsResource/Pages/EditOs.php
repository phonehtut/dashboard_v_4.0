<?php

namespace App\Filament\Resources\OsResource\Pages;

use App\Filament\Resources\OsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOs extends EditRecord
{
    protected static string $resource = OsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
