<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Models\Project;
use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup = 'Task Management';


    public static function form(Form $form): Form
    {
        $user = Filament::auth()->user();

        // Cek apakah user punya role 'super_admin'
        $isSuperAdmin = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('model_has_roles.model_type', get_class($user))
            ->where('roles.name', 'super_admin')
            ->exists();

        $isManager = DB::table('model_has_roles')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('model_has_roles.model_id', $user->id)
            ->where('model_has_roles.model_type', get_class($user))
            ->where('roles.name', 'manager')
            ->exists();

        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\DatePicker::make('deadline'),
                Forms\Components\Select::make('status')
                    ->options([
                        'To Do' => 'To Do',
                        'In Progress' => 'In Progress',
                        'Done' => 'Done',
                    ])
                    ->required()
                    ->default('To Do'),

                ($isSuperAdmin || $isManager)
                    ? Forms\Components\CheckboxList::make('assignedUsers')
                    ->label('Assigned To')
                    ->relationship('assignedUsers', 'name')
                    ->columns(4)
                    : Forms\Components\Hidden::make('assignedUsers')
                    ->default([$user->id]),
            ]);
    }

    public static function table(Table $table): Table
    {

        $projectExists = Project::count() > 0;

        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('project.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('assignedUsers')
                    ->label('Assigned To')
                    ->getStateUsing(function (Task $record) {
                        return $record->assignedUsers->pluck('name')->implode(', ');
                    })
                    ->sortable(),
                SelectColumn::make('status')
                    ->options([
                        'To Do' => 'To Do',
                        'In Progress' => 'In Progress',
                        'Done' => 'Done',
                    ])
                    ->sortable(),
                TextColumn::make('deadline')
                    ->date()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Deleted At'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make(), // Add the Trashed filter
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'To Do' => 'To Do',
                        'In Progress' => 'In Progress',
                        'Done' => 'Done',
                    ]),
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'name'),
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('assignedUsers', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                // Add Restore action for trashed records
                Tables\Actions\RestoreAction::make(),
                // Add Force Delete action for permanent deletion
                Tables\Actions\DeleteAction::make()->label('Force Delete')
                    ->hidden(fn($record) => $record->trashed() === false),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    // Add Restore bulk action for trashed records
                    Tables\Actions\RestoreBulkAction::make(),
                    // Add Force Delete bulk action for permanent deletion
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading($projectExists ? 'Belum Ada Tugas' : 'Belum Ada Proyek')
            ->emptyStateDescription(
                $projectExists
                    ? 'Buat tugas pertamamu untuk mulai mengelola proyek.'
                    : 'Kamu harus membuat proyek terlebih dahulu sebelum dapat membuat tugas.'
            )
            ->emptyStateActions($projectExists ? [
                Tables\Actions\CreateAction::make()
                    ->label('Buat Tugas Pertama'),
            ] : []);
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
