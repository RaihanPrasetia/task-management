<?php

namespace App\Filament\Resources\TaskResource\Pages;

use App\Filament\Resources\TaskResource;
use App\Models\Project;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTasks extends ListRecords
{
    protected static string $resource = TaskResource::class;

    protected function getHeaderActions(): array
    {
        // Cek apakah ada project
        if (Project::count() > 0) {
            return [
                Actions\CreateAction::make(),
            ];
        }

        // Kalau tidak ada project, tidak tampilkan create
        return [];
    }
}
