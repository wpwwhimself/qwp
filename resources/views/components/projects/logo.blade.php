@props([
    "project",
])

<a href="{{ $project->page_url }}" target="_blank"
    class="project-logo rounded"
    style="--accent-color: {{ $project->color }};"
>
    @if ($project->logo_url)
    <img src="{{ $project->logo_url }}" alt="Logo {{ $project->name }}" class="icon">
    @else
    <x-shipyard.app.icon :name="model_icon('projects')" />
    @endif
</a>
