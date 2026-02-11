@extends("layouts.shipyard.admin")
@section("title", request()->get('active') ? "Aktywne zadania" : "Zadania")

@section("sidebar")

<div class="card stick-top">
    @foreach ($clients as $client)
    @continue ($client->id == request("client"))
    <x-shipyard.ui.button
        :icon="model_icon('clients')"
        :pop="$client->name"
        :action="route('tasks.list', ['client' => $client->id])"
    />
    @endforeach
</div>

@endsection

@section("content")

@if (empty(request("client")))
<x-shipyard.app.card>
    <span class="accent danger">Wybierz klienta z menu obok.</span>
</x-shipyard.app.card>

@else
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

    <div class="kanban">
        @foreach ($statuses as $status)
        <div class="flex down">
            <div class="flex right middle spread">
                {!! $status->display_title !!}
                @php $count = count($tasks[$status->id] ?? []) @endphp
                <span class="tag accent background {{ $count > 0 ? 'danger' : 'success' }}">{{ $count }}</span>
            </div>

            @forelse ($tasks[$status->id] ?? [] as $task)
            <x-tasks.kanban-tile :task="$task">
                <x-slot:actions>
                    <x-shipyard.ui.button
                        icon="arrow-right"
                        pop="Przejdź"
                        :action="route('tasks.show', ['task' => $task])"
                    />
                </x-slot:actions>
            </x-tasks.kanban-tile>
            @empty
            <span class="ghost">Brak zadań</span>
            @endforelse
        </div>
        @endforeach
    </div>
</x-shipyard.app.card>

@endsection
