<?php

namespace App\Filament\Resources\ShowResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Section, Grid, SpatieMediaLibraryFileUpload};
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\{Grid as InfoGrid, RepeatableEntry, Section as InfoSection, SpatieMediaLibraryImageEntry, TextEntry};

class EpisodesRelationManager extends RelationManager
{
    protected static string $relationship = 'episodes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Episode Information')
                    ->description('Details about this episode.')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('episode_number')
                                ->required()
                                ->numeric()
                                ->label('Episode Number'),

                            Forms\Components\TextInput::make('title')
                                ->required()
                                ->label('Title'),

                            Forms\Components\TextInput::make('duration')
                                ->label('Duration')
                                ->placeholder('e.g. 45m'),

                            Forms\Components\TextInput::make('airing_time')
                                ->label('Airing Time'),

                            Forms\Components\Textarea::make('description')
                                ->label('Description')
                                ->columnSpanFull(),

                            SpatieMediaLibraryFileUpload::make('thumbnail')
                                ->label('Show Cover')
                                ->collection('episode_cover')
                                ->openable()
                                ->conversion('thumbnail')
                                ->imagePreviewHeight('200')
                                ->columnSpanFull(),

                            SpatieMediaLibraryFileUpload::make('video')
                                ->label('Episode Video')
                                ->collection('episode_video')
                                ->openable()
                                ->columnSpanFull(),
                        ]),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('airing_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make()
                    ->visible(function ($livewire) {
                        return $livewire->getOwnerRecord() && $livewire->getPageClass() === \App\Filament\Resources\ShowResource\Pages\ViewShow::class;
                    })

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                InfoSection::make('Episode Information')
                    ->description('General details about the episode.')
                    ->schema([
                        InfoGrid::make(2)->schema([
                            TextEntry::make('title')->label('Title'),
                            TextEntry::make('duration')->label('Duration'),
                            TextEntry::make('airing_time')
                                ->label('Airing Time'),
                        ]),
                        TextEntry::make('description')
                            ->label('Description')
                            ->columnSpanFull(),

                        SpatieMediaLibraryImageEntry::make('thumbnail')
                            ->label('Thumbnail')
                            ->collection('episode_cover')
                            ->conversion('thumbnail')
                            ->size(200)
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                InfoSection::make('Metadata')
                    ->description('System timestamps.')
                    ->schema([
                        InfoGrid::make(2)->schema([
                            TextEntry::make('created_at')
                                ->label('Created At')
                                ->dateTime(),
                            TextEntry::make('updated_at')
                                ->label('Updated At')
                                ->dateTime(),
                        ]),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }
}
