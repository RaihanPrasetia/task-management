<?php

namespace App\Filament\Resources\AssignUserResource\Pages;

use App\Filament\Resources\AssignUserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateAssignUser extends CreateRecord
{
    protected static string $resource = AssignUserResource::class;

    // Set a custom subheading
    public function getSubheading(): ?string
    {
        return __('Hanya bisa menambahkan user yang belum memiliki role');
    }
}
