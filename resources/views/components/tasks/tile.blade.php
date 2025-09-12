@props([
    "task",
    "fullScopeName" => false,
])

<div role="model-card">
    <div role="top-part">
        <x-statuses.tile :status="$task->status" />
        <div>
            <h3 class="tile-title">{{ $task->name }}</h3>
            <span class="ghost">{{ $fullScopeName ? $task->scope : $task->scope->name }}</span>
        </div>
    </div>

    <div role="middle-part">
        <span>
            <span @popper(Utworzono)><x-shipyard.app.icon name="clock" /></span>
            <span {{ Popper::pop($task->created_at) }}>{{ $task->created_at->diffForHumans() }}</span>
        </span>
        <span>
            <span @popper(Łączny czas poświęcony)><x-shipyard.app.icon name="timer" /></span>
            <span>{{ $task->total_hours_spent }} h</span>
        </span>
    </div>

    <div role="bottom-part">
        <x-shipyard.ui.button
            icon="arrow-right"
            pop="Przejdź"
            :action="route('tasks.show', ['task' => $task])"
        />
    </div>
</div>
