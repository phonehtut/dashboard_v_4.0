<?php

namespace App\Filament\Resources;

use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\InstructorResource\Pages;
use App\Filament\Resources\InstructorResource\RelationManagers;
use App\Models\Instructor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InstructorResource extends Resource
{
    protected static ?string $model = Instructor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Instructor Name')
                    ->required(),
                TextInput::make('type')
                    ->label('Type')
                    ->required(),
                FileUpload::make('photo')
                    ->label('Instructor Photo')
                    ->disk('public')
                    ->directory('instructorsPhotos')
                    ->maxSize(1024)
                    ->image()
                    ->required()
                    ->columnSpan('full'),
                TextInput::make('email')
                    ->label('Email (Optional)'),
                TextInput::make('telegram')
                    ->label('Telegram (Optional)')
                    ->helperText('Only Fill Telegram Username, Eg->user_name01'),
                TextInput::make('facebook')
                    ->label('Facebook Link (Optional)')
                    ->helperText('Fill Full Facebook url')
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable(),
                ImageColumn::make('photo')
                    ->label('Photo')
                    ->disk('public')
                    ->size(50, 50),
                TextInputColumn::make('type')->label('Type'),
                TextInputColumn::make('email')->label('Email')->searchable(),
                TextInputColumn::make('telegram')->label('Telegram')->searchable(),
                TextInputColumn::make('facebook')->label('Facebook'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListInstructors::route('/'),
            'create' => Pages\CreateInstructor::route('/create'),
            'edit' => Pages\EditInstructor::route('/{record}/edit'),
        ];
    }
}
