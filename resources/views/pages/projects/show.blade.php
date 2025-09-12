@extends("layouts.shipyard.admin")
@section("title", $project->name)
@section("subtitle", $project->client->name)

@section("sidebar")

<div class="card stick-top">
    @foreach ($sections as $section)
    <x-shipyard.ui.button
        :icon="$section['icon'] ?? null"
        :pop="$section['label']"
        pop-direction="right"
        :action="'#'.$section['id'] ?? null"
        class="tertiary"
    />
    @endforeach

    <x-shipyard.app.sidebar-separator />

    <x-shipyard.ui.button
        :icon="model_icon('clients')"
        pop="Klient"
        pop-direction="right"
        :action="route('clients.show', ['client' => $project->client])"
    />
</div>

@endsection

@section("content")

<x-shipyard.app.card
    :title="$sections[0]['label']"
    :icon="$sections[0]['icon']"
    :id="$sections[0]['id']"
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
    :title="$sections[1]['label']"
    :icon="$sections[1]['icon']"
    :id="$sections[1]['id']"
>
    @forelse ($project->activeTasks ?? [] as $task)
    <x-tasks.tile :task="$task" />
    @empty
    <p class="ghost"><x-shipyard.app.icon name="check" /> Wszystkie zadania wykonane!</p>
    @endforelse
</x-shipyard.app.card>

<x-shipyard.app.card
    :title="$sections[2]['label']"
    :icon="$sections[2]['icon']"
    :id="$sections[2]['id']"
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
