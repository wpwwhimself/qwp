@extends("layouts.shipyard.admin")
@section("title", "Klienci")

@section("content")

<x-shipyard.app.card
    title="Lista klientów"
    :icon="model_icon('clients')"
>
    <x-slot:actions>
        <x-shipyard.ui.button
            icon="plus"
            label="Dodaj"
            :action="route('admin.model.edit', ['model' => 'client'])"
        />
    </x-slot:actions>

    @forelse ($clients as $client)
    <x-shipyard.app.model.tile :model="$client">
        <x-slot:actions>
            @foreach ($client->projects ?? [] as $project)
            <x-projects.button :project="$project" />
            @endforeach

            <x-shipyard.ui.button
                icon="finance"
                label="Statystyki"
                :action="route('clients.stats', ['client' => $client])"
            />
        </x-slot:actions>
    </x-shipyard.app.model.tile>
    @empty
    <span class="ghost">Brak klientów</span>
    @endforelse

    {{ $clients->links() }}
</x-shipyard.app.card>

@endsection
