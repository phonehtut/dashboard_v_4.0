<?php

// namespace App\Filament\Widgets;

// use App\Models\Student; // Make sure this model exists
// use Filament\Tables;
// use Filament\Tables\Table;
// use Filament\Widgets\TableWidget as BaseWidget;

// class LatestStudents extends BaseWidget
// {
//     protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
//     {
//         return Student::latest(); // This will order students by their creation date, showing the latest ones first
//     }

//     protected function getTableColumns(): array
//     {
//         return [
//             Tables\Columns\TextColumn::make('name')
//                 ->label('Name')
//                 ->sortable()
//                 ->searchable(),
//             Tables\Columns\TextColumn::make('email')
//                 ->label('Email')
//                 ->sortable()
//                 ->searchable(),
//             Tables\Columns\TextColumn::make('created_at')
//                 ->label('Joined At')
//                 ->sortable()
//                 ->dateTime('F j, Y, g:i a'),
//         ];
//     }

//     public function table(Table $table): Table
//     {
//         return $table
//             ->query($this->getTableQuery())
//             ->columns($this->getTableColumns());
//     }
// }
