@extends("layouts.shipyard.admin")
@section("title", $scope->name)
@section("subtitle", $scope->project->name)

@section("content")

<x-shipyard.app.card
    title="W skrócie"
    :icon="model_icon('scopes')"
>
    <x-slot:actions>
        <x-shipyard.ui.button
            icon="pencil"
            label="Edytuj"
            :action="route('admin.model.edit', ['model' => 'scope', 'id' => $scope->id])"
        />
    </x-slot:actions>

    @if ($scope->description)
    {!! \Illuminate\Mail\Markdown::parse($scope->description) !!}
    @endif
</x-shipyard.app.card>

<x-shipyard.app.card
    title="Sesje"
    :icon="model_icon('runs')"
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
