@props([
    "run",
])

<div role="model-card">
    <div role="top-part">
        <div>
            <h3 class="tile-title {{ $run->is_finished ? "" : "accent danger" }}">
                @if ($run->is_finished)
                {{ $run->hours_spent }} h
                @else
                w toku
                @endif
            </h3>
            @if ($run->is_finished)
            <span class="ghost">
                {{ $run->finished_at->diff($run->started_at) }}
            </span>
            @endif
        </div>
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
        @unless ($run->is_finished)
        <x-shipyard.ui.button
            icon="check"
            label="Zakończ sesję"
            :action="route('runs.finish', ['run' => $run])"
            class="danger"
        />
        @endunless
        <x-shipyard.ui.button
            icon="arrow-right"
            pop="Przejdź"
            :action="route('runs.show', ['run' => $run])"
        />
    </div>
</div>
