@extends("layouts.shipyard.admin")
@section("title", $project->name)
@section("subtitle", $project->client->name)

@section("sidebar")

<div class="card stick-top">
    @foreach ($sections as $section)
    <x-shipyard.ui.button
        :icon="$section['icon'] ?? null"
        :pop="$section['label']"
        :action="'#'.$section['id'] ?? null"
        class="tertiary"
    />
    @endforeach

    @if ($project->client->projects()->count())
    <x-shipyard.app.sidebar-separator />

    @foreach ($project->client->projects as $alt_project)
    @continue ($alt_project->id == $project->id)
    <x-projects.button :project="$alt_project" />
    @endforeach
    @endif

    <x-shipyard.app.sidebar-separator />

    <x-shipyard.ui.button
        :icon="model_icon('clients')"
        pop="Klient"
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
            show-for="technical"
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
    <x-shipyard.app.model.tile :model="$task">
        <x-slot:actions>
            <x-shipyard.ui.button
                icon="arrow-right"
                pop="Przejdź"
                :action="route('tasks.show', ['task' => $task])"
            />
        </x-slot:actions>
    </x-shipyard.app.model.tile>
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
            show-for="technical"
        />
    </x-slot:actions>

    @forelse ($project->scopes as $scope)
    <x-shipyard.app.model.tile :model="$scope">
        <x-slot:actions>
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
        </x-slot:actions>
    </x-shipyard.app.model.tile>
    @empty
    <span class="ghost">Brak zdefiniowanych zakresów</span>
    @endforelse
</x-shipyard.app.card>

@endsection
