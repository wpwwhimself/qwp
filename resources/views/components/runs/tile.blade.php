@props([
    "run",
])

<div role="model-card">
    <div role="top-part">
        <h3 class="tile-title">
            @if ($run->is_finished)
            {{ $run->hours_spent }} h
            @else
            w toku
            @endif
        </h3>
    </div>

    <div role="middle-part">
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
    </div>

    <div role="bottom-part">
        <x-shipyard.ui.button
            icon="arrow-right"
            pop="Przejdź"
            :action="route('runs.show', ['run' => $run])"
        />
    </div>
</div>
