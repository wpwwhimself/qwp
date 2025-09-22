@props([
    "scope",
])

<div role="model-card">
    <div role="top-part">
        <h3 class="tile-title">
            <x-shipyard.app.icon :name="$scope->icon" />
            {{ $scope->name }}
        </h3>
    </div>

    <div role="bottom-part">
        <x-shipyard.app.icon-label-value
            :icon="model_icon('tasks')"
            label="Aktualne zadania"
            :class="'accent '.($scope->activeTasks->count() > 0 ? 'danger' : 'success')"
        >
            {{ $scope->activeTasks->count() }}
        </x-shipyard.app.icon-label-value>

        <x-shipyard.ui.button
            icon="plus"
            pop="Nowe zadanie"
            action="none"
            onclick="openModal('create-task', {{ json_encode(['scope_id' => $scope->id]) }});"
            class="tertiary"
            show-for="technical"
        />

        <x-shipyard.ui.button
            icon="arrow-right"
            pop="Przejdź"
            :action="route('scopes.show', ['scope' => $scope])"
        />
    </div>
</div>
