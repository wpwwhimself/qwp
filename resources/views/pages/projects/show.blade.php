@extends("layouts.shipyard.admin")
@section("title", $project->name)
@section("subtitle", $project->client->name)

@section("content")

<x-shipyard.app.card
    title="O projekcie"
    :icon="model_icon('projects')"
>
    <x-slot:actions>
        <x-shipyard.ui.button
            icon="pencil"
            label="Edytuj"
            :action="route('admin.model.edit', ['model' => 'project', 'id' => $project->id])"
        />
    </x-slot:actions>

    <div class="flex right">
        <x-projects.logo :project="$project" />

        <div class="flex down no-gap">
            <h3>{{ $project->name }}</h3>

            @if ($project->repo_url)
            <span>Repozytorium: <a href="{{ $project->repo_url }}" target="_blank">{{ $project->repo_url }}</a></span>
            @endif
        </div>
    </div>
</x-shipyard.app.card>

<x-shipyard.app.card
    title="Zadania do wykonania"
    :icon="model_icon('tasks')"
>
    @forelse ($project->activeTasks ?? [] as $task)
    <x-tasks.tile :task="$task" />
    @empty
    <p class="ghost"><x-shipyard.app.icon name="check" /> Wszystkie zadania wykonane!</p>
    @endforelse
</x-shipyard.app.card>

<x-shipyard.app.card
    title="Zakresy"
    :icon="model_icon('scopes')"
>
    <x-slot:actions>
        <x-shipyard.ui.button
            icon="plus"
            label="Dodaj"
            action="none"
            onclick="openModal('create-scope', {{ json_encode(['project_id' => $project->id]) }});"
            class="tertiary"
        />
    </x-slot:actions>

    @forelse ($project->scopes as $scope)
    <x-scopes.tile :scope="$scope" />
    @empty
    <span class="ghost">Brak zdefiniowanych zakresów</span>
    @endforelse
</x-shipyard.app.card>

@endsection
