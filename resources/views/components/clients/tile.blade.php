@props([
    "client",
])

<div role="model-card">
    <div role="top-part">
        <h3>{{ $client->name }}</h3>
    </div>

    <div role="middle-part">
        @foreach ($client->projects ?? [] as $project)
        <x-projects.button :project="$project" />
        @endforeach
    </div>

    <div role="bottom-part">
        <x-shipyard.ui.button
            icon="finance"
            label="Statystyki"
            :action="route('clients.stats', ['client' => $client])"
        />
    </div>
</div>
