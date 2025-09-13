@props([
    "status",
])

<span style="color: {{ $status->color }};">
    <x-shipyard.app.icon :name="$status->icon" />
    {{ $status->name }}
</span>
