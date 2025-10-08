@props([
    "task",
])

<div {{ $attributes->class([
    "kanban-tile", "tile",
    "flex", "down", "center", "middle",
    "bordered", "rounded", "padded",
]) }}>
    <div role="kanban-tile-title" class="flex right spread nowrap">
        <div>
            {!! $task->display_title !!}
            <span class="ghost">{!! $task->scope !!}</span>
        </div>

        @isset ($actions)
        <div class="actions">
            {{ $actions }}
        </div>
        @endisset
    </div>


    <div class="flex right center middle">
        {!! $task->display_middle_part !!}
    </div>

    <x-shipyard.app.model.timestamps :model="$task" />
</div>
