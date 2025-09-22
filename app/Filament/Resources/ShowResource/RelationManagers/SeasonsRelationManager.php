<?php

namespace App\Filament\Resources\ShowResource\RelationManagers;

use App\Models\Season;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Section, Grid, SpatieMediaLibraryFileUpload};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeasonsRelationManager extends RelationManager
{
    protected static string $relationship = 'seasons';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Season Information')
                    ->description('Enter the season title and number for the selected show.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Season Title'),

                                Forms\Components\TextInput::make('season_number')
                                    ->required()
                                    ->numeric()
                                    ->label('Season Number'),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ])
            ->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('season_number')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('season_number'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->url(fn(Season $record) => route('filament.admin.resources.seasons.edit', $record))
                    ->openUrlInNewTab(false),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
