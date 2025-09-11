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

@endsection
