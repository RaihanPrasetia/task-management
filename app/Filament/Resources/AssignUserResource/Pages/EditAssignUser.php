<?php

namespace App\Filament\Resources\AssignUserResource\Pages;

use App\Filament\Resources\AssignUserResource;
use App\Models\AssignUser;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms;
use Spatie\Permission\Models\Role;

class EditAssignUser extends EditRecord
{
    protected static string $resource = AssignUserResource::class;

    // Override getHeaderActions to include delete action
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // Set a custom subheading
    public function getSubheading(): ?string
    {
        return __('Hanya bisa menambahkan user yang belum memiliki role');
    }
}
