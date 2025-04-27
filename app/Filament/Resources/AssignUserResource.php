<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssignUserResource\Pages;
use App\Models\AssignUser;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class AssignUserResource extends Resource
{
    protected static ?string $model = AssignUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $navigationLabel = 'Assign Role ke User';
    protected static ?string $modelLabel = 'Assign Role';

    public static function form(Form $form): Form
    {
        $isEditMode = $form->getOperation() === 'edit';
        $record = $isEditMode ? $form->getRecord() : null;
        $userName = $isEditMode && $record ? User::find($record->model_id)?->name : null;

        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->visible($isEditMode)
                    ->schema([
                        Forms\Components\Placeholder::make('user_name')
                            ->label('Selected User')
                            ->content($userName ?? 'Unknown user'),
                    ]),

                Forms\Components\Select::make('model_id')
                    ->label('User')
                    ->live()
                    ->options(fn() => User::pluck('name', 'id'))
                    ->searchable()
                    ->disabled($isEditMode)
                    ->dehydrated(true)
                    ->required()
                    ->unique(
                        table: 'model_has_roles',
                        column: 'model_id',
                        ignoreRecord: true,
                    )
                    ->validationMessages([
                        'unique' => 'Pengguna ini sudah memiliki role ini.',
                    ]),

                Forms\Components\Select::make('role_id')
                    ->label('Role')
                    ->options(fn() => Role::pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\Hidden::make('model_type')
                    ->default(\App\Models\User::class),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $query->whereHas('role', function ($query) {
                    $query->where('name', '!=', 'super_admin');
                });
            })
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama User')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.username')
                    ->label('Username')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user.email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('role.name')
                    ->label('Role')
                    ->badge()
                    ->color(fn(string $state) => match ($state) {
                        'super_admin' => 'danger',
                        'manager' => 'warning',
                        'user' => 'primary',
                        default => 'gray',
                    }),
            ])
            ->filters([/* any filters */])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssignUsers::route('/'),
            'create' => Pages\CreateAssignUser::route('/create'),
            'edit' => Pages\EditAssignUser::route('/{record}/edit'),
        ];
    }
}
