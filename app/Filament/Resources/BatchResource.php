<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Batch;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use App\Filament\Exports\BatchExporter;
use App\Filament\Imports\BatchImporter;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use App\Filament\Resources\BatchResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BatchResource\RelationManagers;

class BatchResource extends Resource
{
    protected static ?string $model = Batch::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('bname')
                    ->label('Batch Name')
                    ->required(),
                Select::make('cname')
                    ->label('Class Name')
                    ->options(Course::all()->pluck('cname','cname'))
                    ->required(),
                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->required()
                    ->native(false),
                DatePicker::make('end_date')
                    ->label('End Date')
                    ->required()
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('bname')
                    ->label('Batch Name'),
                TextColumn::make('cname')
                    ->label('Class Name'),
                TextInputColumn::make('start_date')
                    ->label('Start Date'),
                TextInputColumn::make('end_date')
                    ->label('End Date'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ExportAction::make()
                    ->label('Export CSV, XLSX')
                    ->exporter(BatchExporter::class),
                ImportAction::make()
                    ->importer(BatchImporter::class)
            ])
            ->emptyStateActions([
                Action::make('create')
                    ->label('Create Btach')
                    ->url(url('admin/batches/create'))
                    ->icon('heroicon-m-plus')
                    ->button(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\RestoreAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBatches::route('/'),
            'create' => Pages\CreateBatch::route('/create'),
            'edit' => Pages\EditBatch::route('/{record}/edit'),
        ];
    }
}
