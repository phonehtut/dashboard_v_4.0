<?php

namespace App\Filament\Resources\StudentResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\StudentResource;
use Filament\Pages\Actions\Action;

class CreateStudent extends CreateRecord
{
    protected static string $resource = StudentResource::class;

    protected function afterCreate(): void
    {
        $student = $this->record;

        Notification::make()
            ->title('Student Created Succesful')
            ->icon('heroicon-o-academic-cap')
            ->body("**New Student {$student->name} created!**")
            ->sendToDatabase(auth()->user());
    }

    // protected function getCreatedNotificationTitle(): ?string
    // {
    //     return 'Student Created';
    // }

    // protected function getCreatedNotification(): ?Notification
    // {
    //     return Notification::make()
    //         ->success()
    //         ->title('Student Created')
    //         ->body('This Student created Successful.');
    // }
}
