@props([
    "status",
])

<span
    class="accent"
    {{ Popper::pop($status->name) }}
    style="--accent-color: {{ $status->color }};"
>
    <x-shipyard.app.icon :name="$status->icon" />
</span>
