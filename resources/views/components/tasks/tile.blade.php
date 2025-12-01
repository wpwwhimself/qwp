@props([
    "task",
])

<x-shipyard.app.model.tile :model="$task">
    <x-slot:actions>
        <x-shipyard.ui.button
            icon="arrow-right"
            pop="Przejdź"
            :action="route('tasks.show', ['task' => $task])"
        />
    </x-slot:actions>
</x-shipyard.app.model.tile>
