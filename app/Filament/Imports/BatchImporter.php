<?php

namespace App\Filament\Imports;

use App\Models\Batch;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class BatchImporter extends Importer
{
    protected static ?string $model = Batch::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('bname')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('cname')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('start_date')
                ->rules(['date']),
            ImportColumn::make('end_date')
                ->rules(['date']),
        ];
    }

    public function resolveRecord(): ?Batch
    {
        // return Batch::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Batch();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your batch import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
