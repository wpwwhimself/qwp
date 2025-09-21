@extends("layouts.shipyard.admin")
@section("title", request()->get('active') ? "Aktywne zadania" : "Zadania")

@section("sidebar")

<div class="card stick-top">
    <x-shipyard.ui.button
        :icon="model_icon('tasks')"
        :pop="request()->get('active') ? 'Pokaż wszystkie' : 'Pokaż aktywne'"
        pop-direction="right"
        :action="route('tasks.list', ['active' => !request()->get('active')])"
    />
    @if ($activeRun)
    <x-shipyard.ui.button
        :icon="model_icon('runs')"
        pop="Aktywna sesja"
        pop-direction="right"
        :action="route('tasks.show', ['task' => $activeRun->task])"
        class="primary"
    />
    @endif
</div>

@endSection

@section("content")

<x-shipyard.app.card
    title="Lista zadań"
    :icon="model_icon('tasks')"
>
    <x-slot:actions>
        <x-shipyard.ui.button
            icon="plus"
            label="Dodaj"
            :action="route('admin.model.edit', ['model' => 'task'])"
        />
    </x-slot:actions>

    @forelse ($tasks as $task)
    <x-tasks.tile :task="$task" full-scope-name />
    @empty
    <span class="ghost">Brak zadań</span>
    @endforelse

    {{ $tasks->links() }}
</x-shipyard.app.card>

@endsection
