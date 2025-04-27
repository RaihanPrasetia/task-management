<?php

namespace App\Filament\Widgets;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;

class TaskOverview extends Widget
{
    protected static string $view = 'filament.widgets.task-overview';

    protected int | string | array $columnSpan = 'full';

    public function getTasksByStatus()
    {
        return Task::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get()
            ->pluck('total', 'status')
            ->toArray();
    }

    public function getTasksByProject()
    {
        $projects = Project::withCount([
            'tasks as todo_count' => function ($query) {
                $query->where('status', 'To Do');
            },
            'tasks as in_progress_count' => function ($query) {
                $query->where('status', 'In Progress');
            },
            'tasks as done_count' => function ($query) {
                $query->where('status', 'Done');
            },
            'tasks as total_count'
        ])->get();

        return $projects;
    }

    public function getTasksByUser()
    {
        $users = User::where('id', '!=', 1)
            ->withCount([
                'assignedTasks as todo_count' => function ($query) {
                    $query->where('status', 'To Do');
                },
                'assignedTasks as in_progress_count' => function ($query) {
                    $query->where('status', 'In Progress');
                },
                'assignedTasks as done_count' => function ($query) {
                    $query->where('status', 'Done');
                },
                'assignedTasks as total_count'
            ])->get();

        return $users;
    }
}
