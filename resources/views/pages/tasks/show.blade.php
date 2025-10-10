@extends("layouts.shipyard.admin")
@section("title", $task->name)
@section("subtitle", $task->scope)

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

    <x-shipyard.app.sidebar-separator />

    <x-shipyard.ui.button
        :icon="model_icon('projects')"
        pop="Projekt"
        :action="route('projects.show', ['project' => $task->scope->project])"
    />
    <x-shipyard.ui.button
        :icon="model_icon('scopes')"
        pop="Zakres"
        :action="route('scopes.show', ['scope' => $task->scope])"
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
        <x-shipyard.app.model.timestamps :model="$task" />

        <x-shipyard.ui.button
            icon="pencil"
            label="Edytuj"
            :action="route('admin.model.edit', ['model' => 'task', 'id' => $task->id])"
            show-for="technical"
        />
    </x-slot:actions>

    <x-statuses.bar :status="$task->status" :allow-restatus-for-task="$task" />

    @if ($task->description)
    {!! \Illuminate\Mail\Markdown::parse($task->description) !!}
    @endif
</x-shipyard.app.card>

<x-shipyard.app.card
    :title="$sections[1]['label']"
    :icon="$sections[1]['icon']"
    :id="$sections[1]['id']"
>
    <x-slot:actions>
        <x-shipyard.ui.button
            icon="plus"
            label="Rozpocznij nową"
            :action="route('runs.start', ['task' => $task->id])"
            show-for="technical"
        />
    </x-slot:actions>

    <span>Łączny czas poświęcony: <strong>{{ $task->total_hours_spent }} h</strong></span>

    @forelse ($paged_runs as $run)
    <x-runs.tile :run="$run" />
    @empty
    <p class="ghost">To zadanie jeszcze nie ma zarejestrowanych sesji.</p>
    @endforelse

    {{ $paged_runs->links("components.shipyard.pagination.default") }}
</x-shipyard.app.card>

@endsection
