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
    </x-slot:actions>

    @if ($run->description)
    {!! \Illuminate\Mail\Markdown::parse($run->description) !!}
    @endif
</x-shipyard.app.card>

@endsection
