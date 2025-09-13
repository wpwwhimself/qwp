@extends("layouts.shipyard.admin")
@section("title", "Podsumowanie miesięczne prac")
@section("subtitle", \Carbon\Carbon::parse($month)->format("m.Y"))

@section("content")

<x-shipyard.app.card
    title="Podsumowanie"
    icon="cash"
>
    <div class="flex right center">
        <x-shipyard.app.h lvl="3" icon="timer">
            Przepracowano:
            {{ $runs_this_month->sum("hours_spent") }} h
        </x-shipyard.app.h>

        <x-shipyard.app.h lvl="3" icon="cash">
            Wynagrodzenie łączne:
            <span class="accent primary">
                {{ \App\Models\Rate::asPln(\App\Models\Run::costByMonth($runs_this_month, $month)) }}
            </span>
        </x-shipyard.app.h>
    </div>
</x-shipyard.app.card>

<x-shipyard.app.card
    title="Zestawienie prac"
    :icon="model_icon('tasks')"
>
    <div class="ms-cost-row grid">
        <span>Nazwa zadania</span>
        <span>Data przyjęcia</span>
        <span>Czas poświęcony</span>
        <span>Status</span>
        <span>Data wdrożenia</span>
        <span class="number">Wynagrodzenie</span>
    </div>

    @foreach ($data as $project_id => $scopes)
    @php $project = \App\Models\Project::find($project_id); $project_partial_sum = 0; @endphp
    <div class="card">
        <x-shipyard.app.h lvl="3" :icon="model_icon('projects')">{{ $project->name }}</x-shipyard.app.h>

        @foreach ($scopes as $scope_id => $tasks)
        @php $scope = \App\Models\Scope::find($scope_id); $scope_partial_sum = 0; @endphp
            <x-shipyard.app.h lvl="4" :icon="$scope->icon">{{ $scope->name }}</x-shipyard.app.h>

            @foreach ($tasks as $task_id => $runs)
            @php $task = \App\Models\Task::find($task_id); @endphp
            <div class="ms-cost-row grid">
                <span>{{ $task->name }}</span>
                <span>{{ $task->created_at->format("d.m.Y") }}</span>
                <span class="number">{{ $runs->sum("hours_spent") }} h</span>
                <span><x-statuses.icon-name :status="$task->status" /></span>
                <span>
                    @if ($task->is_finished)
                    {{ $task->updated_at->format("d.m.Y") }}
                    @endif
                </span>
                <span class="number">{{ \App\Models\Rate::asPln($task->cost->get($month)) }}</span>
            </div>

            @php
            $scope_partial_sum += $task->cost->get($month);
            $project_partial_sum += $task->cost->get($month);
            @endphp
            @endforeach

        @endforeach

        <hr>

        <div class="ms-cost-row grid">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span class="number"><strong class="accent secondary">{{ \App\Models\Rate::asPln($project_partial_sum) }}</strong></span>
        </div>
    </div>
    @endforeach
</x-shipyard.app.card>

@endsection
