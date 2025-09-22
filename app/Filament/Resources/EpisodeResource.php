<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EpisodeResource\Pages;
use App\Filament\Resources\EpisodeResource\RelationManagers;
use App\Models\Episode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Section, Grid, SpatieMediaLibraryFileUpload};
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\{Grid as InfoGrid, RepeatableEntry, Section as InfoSection, SpatieMediaLibraryImageEntry, TextEntry};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EpisodeResource extends Resource
{
    protected static ?string $model = Episode::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    protected static ?string $navigationGroup = 'TV Shows';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Show')
                    ->description('This episode belongs to a TV show.')
                    ->schema([
                        Forms\Components\Select::make('show_id')
                            ->relationship('show', 'title')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('TV Show')
                    ])
                    ->columns(1)
                    ->collapsible(),

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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('show.title')
                    ->numeric()
                    ->sortable(),
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // Show Info
                InfoSection::make('Show')
                    ->description('The TV show this episode belongs to.')
                    ->schema([
                        TextEntry::make('show.title')
                            ->label('TV Show')
                            ->badge()
                            ->color('info'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // Episode Information
                InfoSection::make('Episode Information')
                    ->description('General details about the episode.')
                    ->schema([
                        InfoGrid::make(2)->schema([
                            TextEntry::make('episode_number')->label('Episode #'),
                            TextEntry::make('title')->label('Title'),
                            TextEntry::make('duration')->label('Duration'),
                            TextEntry::make('airing_time')->label('Airing Time'),
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

                // Metadata
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEpisodes::route('/'),
            'create' => Pages\CreateEpisode::route('/create'),
            'view' => Pages\ViewEpisode::route('/{record}'),
            'edit' => Pages\EditEpisode::route('/{record}/edit'),
        ];
    }
}
