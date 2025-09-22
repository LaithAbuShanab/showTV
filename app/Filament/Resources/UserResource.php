<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\{Section, Grid};
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\{Grid as InfoGrid, RepeatableEntry, Section as InfoSection, SpatieMediaLibraryImageEntry, TextEntry};
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'App users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Basic Info Section
                Section::make('Basic Information')
                    ->description('General user identity details.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Full Name'),

                                SpatieMediaLibraryFileUpload::make('avatar')
                                    ->label('Avatar')
                                    ->collection('avatar')
                                    ->openable()
                                    ->conversion('user_avatar'),
                            ]),
                    ])
                    ->columns(1),

                // Authentication Section
                Section::make('Authentication')
                    ->description('Login credentials and access.')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Email'),

                                Forms\Components\TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Password')
                                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                                    ->visibleOn('create')
                            ]),
                    ])
                    ->columns(1),

                Section::make('Roles & Permissions')
                    ->description('Assign user roles and permissions.')
                    ->schema([
                        Forms\Components\CheckboxList::make('roles')
                            ->relationship(name: 'roles', titleAttribute: 'name')
                            ->searchable(),
                    ])
                    ->columns(1),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('roles.name') // relationship column
                    ->label('Roles')
                    ->badge()
                    ->separator(', ')
                    ->colors([
                        'info',
                    ]),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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
            ])->modifyQueryUsing(function (Builder $query) {
                $query
                    ->where('id', '!=', Auth::id())
                    ->orWhere('id', '!=', 1);
            });
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                // Basic Info Section
                InfoSection::make('Basic Information')
                    ->description('General user identity details.')
                    ->schema([
                        InfoGrid::make(2)
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Full Name'),

                                SpatieMediaLibraryImageEntry::make('avatar')
                                    ->collection('avatar')
                                    ->conversion('user_avatar')
                                    ->label('Avatar'),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // Authentication Section
                InfoSection::make('Authentication')
                    ->description('Email, password and verification details.')
                    ->schema([
                        InfoGrid::make(2)
                            ->schema([
                                TextEntry::make('email')
                                    ->label('Email'),

                                TextEntry::make('email_verified_at')
                                    ->label('Email Verified At')
                                    ->dateTime(),

                                TextEntry::make('password')
                                    ->label('Password')
                                    ->hidden(),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // Roles & Permissions
                InfoSection::make('Roles & Permissions')
                    ->description('Assigned roles and permissions for this user.')
                    ->schema([
                        RepeatableEntry::make('roles')
                            ->label('Roles')
                            ->schema([
                                InfoGrid::make(2)
                                    ->schema([
                                        TextEntry::make('name')
                                            ->label('Role Name')
                                            ->badge()
                                            ->color('info'),
                                    ]),
                            ])
                            ->columns(1),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
