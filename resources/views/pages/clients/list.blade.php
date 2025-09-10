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
    <x-clients.tile :client="$client" />
    @empty
    <span class="ghost">Brak klientów</span>
    @endforelse

    {{ $clients->links() }}
</x-shipyard.app.card>

@endsection
