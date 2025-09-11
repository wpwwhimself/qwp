@props([
    "task",
])

<div role="model-card">
    <div role="top-part">
        <x-statuses.tile :status="$task->status" />
        <div>
            <h3 class="tile-title">{{ $task->name }}</h3>
            <span class="ghost">{{ $task->scope->name }}</span>
        </div>
    </div>

    <div role="middle-part">
    </div>

    <div role="bottom-part">
        <x-shipyard.ui.button
            icon="arrow-right"
            pop="Przejdź"
            :action="route('tasks.show', ['task' => $task])"
        />
    </div>
</div>
