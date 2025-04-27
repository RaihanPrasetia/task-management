<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Task Overview
        </x-slot>

        <div x-data="{ tab: 'status' }" class="space-y-4">
            <div class="flex space-x-4 border-b border-gray-200 dark:border-gray-700">
                <button x-on:click="tab = 'status'"
                    :class="{ 'border-primary-500 text-primary-600': tab === 'status', 'border-transparent': tab !== 'status' }"
                    class="px-4 py-2 font-medium border-b-2 hover:text-primary-500">
                    By Status
                </button>
                <button x-on:click="tab = 'project'"
                    :class="{ 'border-primary-500 text-primary-600': tab === 'project', 'border-transparent': tab !== 'project' }"
                    class="px-4 py-2 font-medium border-b-2 hover:text-primary-500">
                    By Project
                </button>
                <button x-on:click="tab = 'user'"
                    :class="{ 'border-primary-500 text-primary-600': tab === 'user', 'border-transparent': tab !== 'user' }"
                    class="px-4 py-2 font-medium border-b-2 hover:text-primary-500">
                    By User
                </button>
            </div>

            <div x-show="tab === 'status'" class="space-y-4">
                @php
                    $tasksByStatus = $this->getTasksByStatus();
                    $total = array_sum($tasksByStatus);
                    $todoCount = $tasksByStatus['To Do'] ?? 0;
                    $inProgressCount = $tasksByStatus['In Progress'] ?? 0;
                    $doneCount = $tasksByStatus['Done'] ?? 0;
                @endphp

                <div class="flex justify-around text-center">
                    <div class="p-4 bg-gray-100 dark:bg-gray-800 rounded-lg">
                        <h3 class="text-lg font-medium">Total Tasks</h3>
                        <p class="text-3xl font-bold">{{ $total }}</p>
                    </div>
                    <div class="p-4 bg-red-100 dark:bg-red-900 rounded-lg">
                        <h3 class="text-lg font-medium">To Do</h3>
                        <p class="text-3xl font-bold">{{ $todoCount }}</p>
                    </div>
                    <div class="p-4 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <h3 class="text-lg font-medium">In Progress</h3>
                        <p class="text-3xl font-bold">{{ $inProgressCount }}</p>
                    </div>
                    <div class="p-4 bg-green-100 dark:bg-green-900 rounded-lg">
                        <h3 class="text-lg font-medium">Done</h3>
                        <p class="text-3xl font-bold">{{ $doneCount }}</p>
                    </div>
                </div>
            </div>

            <div x-show="tab === 'project'" class="space-y-4">
                <table class="w-full text-left border border-gray-200 dark:border-gray-700">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-800">
                            <th class="px-4 py-2">Project</th>
                            <th class="px-4 py-2">To Do</th>
                            <th class="px-4 py-2">In Progress</th>
                            <th class="px-4 py-2">Done</th>
                            <th class="px-4 py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->getTasksByProject() as $project)
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-2">{{ $project->name }}</td>
                                <td class="px-4 py-2">{{ $project->todo_count }}</td>
                                <td class="px-4 py-2">{{ $project->in_progress_count }}</td>
                                <td class="px-4 py-2">{{ $project->done_count }}</td>
                                <td class="px-4 py-2">{{ $project->total_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div x-show="tab === 'user'" class="space-y-4">
                <table class="w-full text-left border border-gray-200 dark:border-gray-700">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-800">
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">To Do</th>
                            <th class="px-4 py-2">In Progress</th>
                            <th class="px-4 py-2">Done</th>
                            <th class="px-4 py-2">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->getTasksByUser() as $user)
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->todo_count }}</td>
                                <td class="px-4 py-2">{{ $user->in_progress_count }}</td>
                                <td class="px-4 py-2">{{ $user->done_count }}</td>
                                <td class="px-4 py-2">{{ $user->total_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
