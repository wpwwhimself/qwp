@extends("layouts.shipyard.admin")
@section("title", $task->name)
@section("subtitle", $task->scope->name)

@section("content")

<x-shipyard.app.card
    title="W skrócie"
    :icon="model_icon('tasks')"
>
    <x-slot:actions>
        <x-shipyard.ui.button
            icon="pencil"
            label="Edytuj"
            :action="route('admin.model.edit', ['model' => 'task', 'id' => $task->id])"
        />
    </x-slot:actions>

    <x-statuses.bar :status="$task->status" :allow-restatus-for-task="$task" />

    @if ($task->description)
    {!! \Illuminate\Mail\Markdown::parse($task->description) !!}
    @endif
</x-shipyard.app.card>

<x-shipyard.app.card
    title="Sesje"
    :icon="model_icon('runs')"
>
    <x-slot:actions>
        <x-shipyard.ui.button
            icon="plus"
            label="Rozpocznij nową"
            :action="route('runs.start', ['task' => $task->id])"
        />
    </x-slot:actions>

    @forelse ($task->runs ?? [] as $run)
    <x-runs.tile :run="$run" />
    @empty
    <p class="ghost">To zadanie jeszcze nie ma zarejestrowanych sesji.</p>
    @endforelse
</x-shipyard.app.card>

@endsection
