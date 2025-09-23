@props([
    "project",
])

<div role="model-card">
    <div role="top-part">
        <h3 class="tile-title">
            <span style="color: {{ $project->color }};">
                <x-shipyard.app.icon :name="model_icon('projects')" />
            </span>
            {{ $project->name }}
        </h3>
    </div>

    <div role="bottom-part">
        
    </div>
</div>

