<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShowResource\Pages;
use App\Filament\Resources\ShowResource\RelationManagers;
use App\Filament\Resources\ShowResource\RelationManagers\EpisodesRelationManager;
use App\Filament\Resources\ShowResource\RelationManagers\FollowersRelationManager;
use App\Filament\Resources\ShowResource\RelationManagers\SeasonsRelationManager;
use App\Models\Episode;
use App\Models\Show;
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

class ShowResource extends Resource
{
    protected static ?string $model = Show::class;

    protected static ?string $navigationIcon = 'heroicon-o-tv';

    protected static ?string $navigationGroup = 'TV Shows';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Section::make('Show Information')
                                    ->description('Basic details about the series or TV show.')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Title'),

                                        Forms\Components\TextInput::make('airing_time')
                                            ->maxLength(255)
                                            ->label('Airing Time')
                                            ->placeholder('e.g. Monday–Thursday @ 8:30PM'),

                                        Forms\Components\Textarea::make('description')
                                            ->label('Description')
                                            ->rows(4),

                                        SpatieMediaLibraryFileUpload::make('thumbnail')
                                            ->label('Show Cover')
                                            ->collection('show_cover')
                                            ->openable()
                                            ->conversion('thumbnail')
                                            ->imagePreviewHeight('200')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(1)
                                    ->collapsible(),
                            ])
                            ->columnSpan(2),

                        Section::make('Tags')
                            ->description('Attach multiple tags to classify the show.')
                            ->schema([
                                Forms\Components\Select::make('tags')
                                    ->multiple()
                                    ->relationship('tags', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->label('Tags'),
                            ])
                            ->columns(1)
                            ->collapsible()
                            ->columnSpan(1),
                    ]),

                Section::make('Category')
                    ->description('Assign the show to a main category.')
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->label('Category'),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('airing_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
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
                InfoSection::make('Show Information')
                    ->description('General details about the video show.')
                    ->schema([
                        InfoGrid::make(2)
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Title'),

                                TextEntry::make('airing_time')
                                    ->label('Airing Time'),

                                TextEntry::make('description')
                                    ->label('Description'),

                                SpatieMediaLibraryImageEntry::make('thumbnail')
                                    ->collection('show_cover')
                                    ->conversion('thumbnail')
                                    ->label('Show Cover'),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible(),

                InfoSection::make('Category')
                    ->description('Main category of this show.')
                    ->schema([
                        TextEntry::make('category.name')
                            ->label('Category')
                            ->badge()
                            ->color('info'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                InfoSection::make('Tags')
                    ->description('Tags attached to this show.')
                    ->schema([
                        TextEntry::make('tags.name')
                            ->label('Tags')
                            ->badge()
                            ->separator(' ')
                            ->color('success'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                InfoSection::make('Metadata')
                    ->description('System timestamps for this show.')
                    ->schema([
                        InfoGrid::make(2)
                            ->schema([
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
            SeasonsRelationManager::class,
            FollowersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShows::route('/'),
            'create' => Pages\CreateShow::route('/create'),
            'view' => Pages\ViewShow::route('/{record}'),
            'edit' => Pages\EditShow::route('/{record}/edit'),
        ];
    }
}
