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
        <span class="accent {{ $scope->activeTasks->count() > 0 ? "danger" : "success" }}">
            <span role="icon" @popper(Aktualne zadania)>
                <x-shipyard.app.icon :name="model_icon('tasks')" />
            </span>
            <span role="value">
                {{ $scope->activeTasks->count() }}
            </span>
        </span>

        <x-shipyard.ui.button
            icon="plus"
            pop="Nowe zadanie"
            action="none"
            onclick="openModal('create-task', {{ json_encode(['scope_id' => $scope->id]) }});"
            class="tertiary"
        />

        <x-shipyard.ui.button
            icon="pencil"
            pop="Edytuj"
            :action="route('admin.model.edit', ['model' => 'scope', 'id' => $scope->id])"
        />
    </div>
</div>
