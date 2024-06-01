<?php

namespace App\Filament\Resources;

use App\Models\Os;
use Filament\Forms;
use Filament\Tables;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Gender;
use App\Models\Student;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\StudentResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\StudentResource\RelationManagers;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $slug = 'students';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('Name')->required(),
                TextInput::make('email')->label('Email')->required()->email(),
                TextInput::make('phone')->label('Phone')->required()->numeric(),
                DatePicker::make('birth_date')->label('Birth Date')->native(false)->required(),
                TextInput::make('age')->label('Age')->numeric()->required(),
                Select::make('gender')->label('Gender')
                    ->options(Gender::all()->pluck('name', 'name'))
                    ->required(),
                Select::make('class')->label('Class')
                    ->options(Course::all()->pluck('cname', 'cname'))
                    ->searchable()
                    ->required(),
                Select::make('batch')->label('Batch')
                    ->options(Batch::all()->pluck('bname', 'bname'))
                    ->required(),
                Select::make('os')->label('Operating System')
                    ->columns(1)
                    ->options(Os::all()->pluck('name', 'name'))
                    ->required(),
                TextInput::make('photo')
                    ->label('Photo Path')
                    ->disabled(),
                FileUpload::make('photo')
                    ->label('Upload Photo')
                    ->disk('public')
                    ->directory('photos')
                    ->maxSize(1024)
                    ->image()
                    ->required()
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
                TextColumn::make('email')->label('Email'),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('birth_date')->label('Birth Date')->date(),
                TextColumn::make('age')->label('Age'),
                TextColumn::make('gender')->label('Gender'),
                TextColumn::make('class')->label('Course'),
                TextColumn::make('batch')->label('Batch'),
                TextColumn::make('os')->label('Operating System'),
                TextColumn::make('ip')->label('IP Address'),
            ])
            ->filters([
                SelectFilter::make('gender')
                    ->multiple()
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female'
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                DeleteAction::make(),
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
            // Define any relations here if needed
        ];
    }

    public static function getNavigationLabel(): string
    {
        return 'Students';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }

}
