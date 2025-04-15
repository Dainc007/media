<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Livewire\ScanbotComponent;
use App\Models\User;
use DesignTheBox\BarcodeField\Forms\Components\BarcodeInput;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

final class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                self::getAvatarFileUploadComponent()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),

                SpatieMediaLibraryFileUpload::make('documents'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
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
                Tables\Actions\EditAction::make()->visible(Auth::user()->id === 1),
                Tables\Actions\DeleteAction::make()->visible(Auth::user()->id === 1),
                Tables\Actions\Action::make('scan')
                    ->button()
                    ->color('success')
                    ->icon('heroicon-o-camera')
                    ->url(fn (User $record): string => '/quickstart')
            ])
            ->actionsPosition(Tables\Enums\ActionsPosition::BeforeColumns)
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageUsers::route('/'),
        ];
    }

    public static function getAvatarFileUploadComponent(): SpatieMediaLibraryFileUpload
    {
        return SpatieMediaLibraryFileUpload::make('avatars')
            ->responsiveImages()
            ->collection('avatars')
            ->conversion('thumb')
            ->hiddenLabel()
            ->alignCenter()
            ->image()
            ->imageEditor()
            ->circleCropper()
            ->avatar()
            ->directory('avatars')
            ->disk('public')
            ->afterStateHydrated(function ($state, callable $set, callable $get, $record): void {
                if ($record) {
                    $record->avatar_url = $record->getFilamentAvatarUrl();
                    $record->save();
                }
            });
    }
}
