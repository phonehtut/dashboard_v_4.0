<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Course;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextInputColumn;
use App\Filament\Resources\CourseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CourseResource\RelationManagers;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('cname')
                    ->label('Class Name')
                    ->required(),
                TextInput::make('skill_level')
                    ->label('Skill Level'),
                FileUpload::make('photo')
                    ->label('Class Photo')
                    ->disk('public')
                    ->directory('class_photos')
                    ->maxSize(1024)
                    ->image()
                    ->required()
                    ->columnSpan('full'),
                TextInput::make('instructor')
                    ->label('Instructor')
                    ->required(),
                TextInput::make('price')
                    ->label('Price')
                    ->required(),
                DatePicker::make('start_date')
                    ->label('Start Date')
                    ->native(false),
                DatePicker::make('end_date')
                    ->label('End Date')
                    ->native(false),
                RichEditor::make('description')
                    ->label('Description')
                    ->columnSpan('full')
                    ->toolbarButtons([
                        // 'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        // 'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cname')
                    ->label('Class Name'),
                TextColumn::make('skill_level')
                    ->label('Skill Level'),
                ImageColumn::make('photo')
                    ->label('Photo')
                    ->disk('public')
                    ->size(50, 50),
                TextInputColumn::make('instructor')
                    ->label('Instructor'),
                TextInputColumn::make('price')
                    ->label('Price'),
                TextColumn::make('description')
                    ->label('Description'),
                TextColumn::make('start_date')
                    ->label('Start Date'),
                TextColumn::make('end_date')
                    ->label('End Date'),

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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
