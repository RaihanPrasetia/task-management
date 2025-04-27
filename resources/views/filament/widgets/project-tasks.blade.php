<div class="overflow-hidden bg-white shadow sm:rounded-lg">
    <div class="px-4 py-5 sm:px-6">
        {{-- <h3 class="text-lg font-medium leading-6 text-gray-900">Tasks for Project: {{ $this->project->name }}</h3> --}}
    </div>
    <div class="border-t border-gray-200">
        <ul role="list" class="divide-y divide-gray-200">
            @foreach ($this->getTasks() as $task)
                <li class="px-4 py-3 sm:px-6">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-900">{{ $task->title }}</span>
                        <span class="text-sm text-gray-500">{{ $task->status }}</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
