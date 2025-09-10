@props([
    "project",
])

<a href="{{ route('projects.show', $project) }}" class="button"
    {{ Popper::pop($project->name) }}
    style="--accent-color: {{ $project->color }};"
>
    @if ($project->logo_url)
    <img src="{{ $project->logo_url }}" alt="Logo {{ $project->name }}" class="icon">
    @else
    <x-shipyard.app.icon :name="model_icon('projects')" />
    @endif
</a>
