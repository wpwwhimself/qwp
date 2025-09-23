@extends("layouts.shipyard.admin")
@section("title", "Statystyki klienta $client->name")

@section("sidebar")

<div class="card stick-top">
    @foreach ($sections as $section)
    <x-shipyard.ui.button
        :icon="$section['icon'] ?? null"
        :pop="$section['label']"
        pop-direction="right"
        :action="'#'.$section['id']"
        class="tertiary"
    />
    @endforeach

    <x-shipyard.app.sidebar-separator />

    <x-shipyard.ui.button
        :icon="model_icon('clients')"
        pop="Klient"
        pop-direction="right"
        :action="route('clients.show', ['client' => $client])"
    />
</div>

@endsection

@section("content")

<x-shipyard.app.card
    :title="$sections[0]['label']"
    :icon="$sections[0]['icon']"
    :id="$sections[0]['id']"
>
    @foreach ($client->projects as $project)
    <x-shipyard.app.model.tile :model="$project">
        <x-slot:actions>
            <x-shipyard.app.icon-label-value
                :icon="model_icon('tasks')"
                label="Aktualne zadania"
                :class="'accent '.($project->activeTasks->count() > 0 ? 'danger' : 'success')"
            >
                {{ $project->activeTasks->count() }}
            </x-shipyard.app.icon-label-value>

            <x-shipyard.ui.button
                icon="arrow-right"
                pop="Przejdź"
                :action="route('projects.show', ['project' => $project])"
            />
        </x-slot:actions>
    </x-shipyard.app.model.tile>
    @endforeach
</x-shipyard.app.card>

<x-shipyard.app.card
    :title="$sections[1]['label']"
    :icon="$sections[1]['icon']"
    :id="$sections[1]['id']"
>
    @foreach ($client->runs_by_month as $month => $runs)
    <x-clients.monthly-summary-tile :client="$client" :month="$month" :runs="$runs" />
    @endforeach
</x-shipyard.app.card>

@endsection
