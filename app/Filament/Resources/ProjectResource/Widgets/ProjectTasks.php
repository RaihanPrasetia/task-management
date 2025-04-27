<?php

namespace App\Filament\Resources\ProjectResource\Widgets;

use App\Models\Task;
use Filament\Widgets\Widget;

class ProjectTasks extends Widget
{
    protected static string $view = 'filament.widgets.project-tasks';


    // Properti untuk menyimpan data project
    public $project;

    // Menetapkan data project ke widget
    public function setProject($project)
    {
        $this->project = $project;
    }

    // Mendapatkan tugas yang terkait dengan proyek
    public function getTasks()
    {
        // Ambil data tugas berdasarkan project_id
        if ($this->project) {
            // Ambil data tugas berdasarkan project_id yang cocok
            return Task::where('project_id', $this->project->id)->get();
        }
        return collect(); // Kembalikan collection kosong jika tidak ada project
    }
}
