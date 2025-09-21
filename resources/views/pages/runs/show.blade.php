@extends("layouts.shipyard.admin")
@section("title", "Zarządzanie sesją")
@section("subtitle", $run->task->name)

@section("content")

<x-shipyard.app.card
    title="W skrócie"
    :icon="model_icon('runs')"
>
    <x-slot:actions>
        <div>
            @foreach ([
                "started_at",
                "finished_at",
            ] as $field_name)
            <x-shipyard.app.model.field-value :model="$run" :field="$field_name">
                {{ $run->{$field_name} }}
            </x-shipyard.app.model.field-value>
            @endforeach
        </div>

        @if (auth()->user()->hasRole("technical"))
        <x-shipyard.ui.button
            icon="pencil"
            label="Edytuj"
            :action="route('admin.model.edit', ['model' => 'run', 'id' => $run->id])"
        />
        @unless ($run->is_finished)
        <x-shipyard.ui.button
            icon="check"
            label="Zakończ sesję"
            :action="route('runs.finish', ['run' => $run])"
            class="danger"
        />
        @endunless
        @endif
    </x-slot:actions>

    @if ($run->description)
    {!! \Illuminate\Mail\Markdown::parse($run->description) !!}
    @endif

    @unless ($run->is_finished)
    <p>Sesja obecnie trwa. Czas poświęcony póki co: <strong id="timer" class="accent primary">???</strong>.</p>

    <script>
    const timer = document.getElementById("timer");

    setInterval(() => {
        const diff = new Date().getTime() - new Date("{{ $run->started_at }}").getTime();
        const hours = Math.floor(diff / 1000 / 60 / 60);
        const minutes = (Math.floor(diff / 1000 / 60) % 60).toString().padStart(2, "0");
        const seconds = (Math.floor(diff / 1000) % 60).toString().padStart(2, "0");
        timer.innerHTML = `${hours}:${minutes}:${seconds}`;
    });
    </script>
    @endunless
</x-shipyard.app.card>

@if (!$run->is_finished && $run->task->description)
<x-shipyard.app.card
    title="O zadaniu"
    :icon="model_icon('tasks')"
>
    {!! \Illuminate\Mail\Markdown::parse($run->task->description) !!}
</x-shipyard.app.card>
@endif

@endsection
