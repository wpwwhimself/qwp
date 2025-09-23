@extends("layouts.shipyard.admin")
@section("title", request()->get('active') ? "Aktywne zadania" : "Zadania")

@section("sidebar")

<div class="card stick-top">
    <x-shipyard.ui.button
        icon="set-all"
        pop="Pokaż wszystkie"
        pop-direction="right"
        :action="route('tasks.list')"
    />
    <x-shipyard.ui.button
        icon="timer-sand"
        pop="Pokaż oczekujące"
        pop-direction="right"
        :action="route('tasks.list', ['filter' => 'pending'])"
    />
    <x-shipyard.ui.button
        icon="fire"
        pop="Pokaż aktywne"
        pop-direction="right"
        :action="route('tasks.list', ['filter' => 'active'])"
    />
    <x-shipyard.ui.button
        icon="pencil"
        pop="Pokaż do opisania"
        pop-direction="right"
        :action="route('tasks.list', ['filter' => 'out-ready'])"
    />
    <x-shipyard.ui.button
        icon="test-tube"
        pop="Pokaż w testach"
        pop-direction="right"
        :action="route('tasks.list', ['filter' => 'tested'])"
    />

    @if ($activeRun)
    <x-shipyard.app.sidebar-separator />

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
    <span class="ghost">Brak zadań</span>
    @endforelse

    {{ $tasks->links() }}
</x-shipyard.app.card>

@endsection
