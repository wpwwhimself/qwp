@props([
    "status",
    "allowRestatusForTask" => null,
])

@php
$restatus_functions = ($allowRestatusForTask)
    ? collect(range(1, $status->maxIndex()))
        ->map(fn ($i) => [
            "restatusTask('" . route("tasks.restatus", ['task' => $allowRestatusForTask, 'new_status_index' => $i]) . "');",
            "Przenieś do: " . \App\Models\Status::where("index", $i)->first()->name,
        ])
    : [];
@endphp

<x-shipyard.app.phase-bar
    :total="$status->maxIndex()"
    :current="$status->index"
    :color="$status->color"
    :click-functions="$restatus_functions"
>
    <h3>
        <x-shipyard.app.icon :name="$status->icon" />
        {{ $status->name }}
    </h3>
</x-shipyard.app.phase-bar>
