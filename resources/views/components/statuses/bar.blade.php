@props([
    "status",
    "allowRestatusForTask" => null,
])

<div class="status-bar" style="color: {{ $status->color }};">
    <h3>
        <x-shipyard.app.icon :name="$status->icon" />
        {{ $status->name }}
    </h3>
    <div role="bars" style="--max-index: {{ $status->maxIndex() }};">
        @for ($i = 1; $i <= $status->maxIndex(); $i++)
        @if ($allowRestatusForTask && $i != $status->index)
        <a href="{{ route("tasks.restatus", ['task' => $allowRestatusForTask, 'new_status_index' => $i]) }}"
        @else
        <div
        @endif
            role="cell"
            {{ ($i <= $status->index) ? "class=highlighted" : "" }}
        @if ($allowRestatusForTask && $i != $status->index)
        ></a>
        @else
        ></div>
        @endif
        @endfor
    </div>
</div>
