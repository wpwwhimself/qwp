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
                {{ $run->time_spent }}
            </span>
            @endif
        </div>
    </div>

    <div role="middle-part">
        <x-shipyard.app.model.fields-preview :model="$run"
            :fields="[
                'started_at',
                'finished_at',
            ]"
        />
    </div>

    <div role="bottom-part">
        @unless ($run->is_finished)
        <x-shipyard.ui.button
            icon="check"
            label="Zakończ sesję"
            :action="route('runs.finish', ['run' => $run])"
            class="danger"
        />
        @else
        <x-shipyard.ui.button
            icon="pencil"
            pop="Edytuj"
            action="none"
            onclick="openModal(`edit-run`, {
                run_id: {{ $run->id }},
                started_at: `{{ $run->started_at }}`,
                finished_at: `{{ $run->finished_at }}`,
                hours_spent: {{ $run->hours_spent }},
            })"
            class="tertiary"
        />
        @endunless
    </div>
</div>
