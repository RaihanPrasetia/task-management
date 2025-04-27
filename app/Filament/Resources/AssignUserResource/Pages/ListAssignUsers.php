<?php

namespace App\Filament\Resources\AssignUserResource\Pages;

use App\Filament\Resources\AssignUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssignUsers extends ListRecords
{
    protected static string $resource = AssignUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
