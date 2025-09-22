@extends("layouts.shipyard.admin")
@section("title", $scope->name)
@section("subtitle", $scope->project->name)

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
        :icon="model_icon('projects')"
        pop="Projekt"
        pop-direction="right"
        :action="route('projects.show', ['project' => $scope->project])"
    />
</div>

@endSection

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
            :action="route('admin.model.edit', ['model' => 'scope', 'id' => $scope->id])"
            show-for="technical"
        />
    </x-slot:actions>

    @if ($scope->description)
    {!! \Illuminate\Mail\Markdown::parse($scope->description) !!}
    @endif
</x-shipyard.app.card>

<x-shipyard.app.card
    :title="$sections[1]['label']"
    :icon="$sections[1]['icon']"
    :id="$sections[1]['id']"
>
    <x-slot:actions>
    </x-slot:actions>

    @forelse ($scope->tasks ?? [] as $task)
    <x-tasks.tile :task="$task" />
    @empty
    <p class="ghost">Brak zadań dla tego zakresu.</p>
    @endforelse
</x-shipyard.app.card>

@endsection
