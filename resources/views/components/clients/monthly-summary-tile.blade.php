@props([
    "client",
    "month",
    "runs",
])

<div role="model-card">
    <div role="top-part">
        <h3>{{ \Carbon\Carbon::parse($month)->format("m.Y") }}</h3>
    </div>

    <div role="middle-part">
        <x-shipyard.app.icon-label-value
            icon="timer"
            label="Czas poświęcony"
        >
            {{ $runs->sum("hours_spent") }} h
        </x-shipyard.app.icon-label-value>
        <x-shipyard.app.icon-label-value
            icon="cash"
            label="Wycena prac"
        >
            @php
            $total_cost = \App\Models\Run::costByMonth($runs, $month);
            @endphp
            {{ \App\Models\Rate::asPln($total_cost) }}
        </x-shipyard.app.icon-label-value>
    </div>

    <div role="bottom-part">
        <x-shipyard.ui.button
            icon="arrow-right"
            pop="Przejdź"
            :action="route('clients.monthly-summary', ['client' => $client, 'month' => $month])"
        />
    </div>
</div>
