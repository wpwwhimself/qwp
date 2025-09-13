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
        <x-shipyard.app.icon-label-value
            :icon="model_icon('tasks')"
            label="Aktualne zadania"
            :class="'accent '.($project->activeTasks->count() > 0 ? 'danger' : 'success')"
        >
            {{ $project->activeTasks->count() }}
        </x-shipyard.app.icon-label-value>

        <x-shipyard.ui.button
            icon="arrow-right"
            pop="Przejdź"
            :action="route('projects.show', ['project' => $project])"
        />
    </div>
</div>

