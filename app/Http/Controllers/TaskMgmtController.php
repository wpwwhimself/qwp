<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Run;
use App\Models\Scope;
use App\Models\Status;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskMgmtController extends Controller
{
    #region clients
    public function clients()
    {
        $clients = Client::withCount("projects")
            ->withCount("user")
            ->paginate(25);

        return view("pages.clients.list", compact(
            "clients",
        ));
    }
    #endregion

    #region projects
    public function projects()
    {
        abort(501);
    }

    public function project(Project $project)
    {
        $sections = [
            [
                "label" => "O projekcie",
                "id" => "projects",
                "icon" => model_icon("projects"),
            ],
            [
                "label" => "Zadania do wykonania",
                "id" => "active_tasks",
                "icon" => model_icon("tasks"),
            ],
            [
                "label" => "Zakresy",
                "id" => "scopes",
                "icon" => model_icon("scopes"),
            ],
        ];

        return view("pages.projects.show", compact(
            "project",
            "sections",
        ));
    }
    #endregion

    #region scopes
    public function scopes()
    {
        abort(501);
    }

    public function scope(Scope $scope)
    {
        $sections = [
            [
                "label" => "W skrócie",
                "id" => "scope",
                "icon" => model_icon("scopes"),
            ],
            [
                "label" => "Zadania",
                "id" => "tasks",
                "icon" => model_icon("tasks"),
            ],
        ];

        return view("pages.scopes.show", compact(
            "scope",
            "sections",
        ));
    }

    public function scopeCreate(Request $rq)
    {
        Scope::create([
            "name" => $rq->name,
            "project_id" => $rq->project_id,
        ]);

        return back()->with("toast", ["success", "Zakres utworzony"]);
    }
    #endregion

    #region tasks
    public function tasks()
    {
        abort(501);
    }

    public function task(Task $task)
    {
        $sections = [
            [
                "label" => "W skrócie",
                "id" => "task",
                "icon" => model_icon("tasks"),
            ],
            [
                "label" => "Sesje",
                "id" => "runs",
                "icon" => model_icon("runs"),
            ],
        ];

        return view("pages.tasks.show", compact(
            "task",
            "sections",
        ));
    }

    public function taskRestatus(Task $task, int $new_status_index)
    {
        $task->update([
            "status_id" => Status::where("index", $new_status_index)->first()->id,
        ]);
        return back()->with("toast", ["success", "Status zmieniony"]);
    }

    public function taskCreate(Request $rq)
    {
        $scope = Scope::findOrFail($rq->scope_id);

        $task = Task::create([
            "name" => $rq->name,
            "scope_id" => $scope->id,
            "description" => $rq->description,
            "status_id" => Status::where("index", 1)->first()->id,
            "rate_id" => $scope->project->client->default_rate_id,
            "rate_value" => $scope->project->client->default_rate_value,
        ]);

        return back()->with("toast", ["success", "Zadanie utworzone"]);
    }
    #endregion

    #region runs
    public function runs()
    {
        abort(501);
    }

    public function run(Run $run)
    {
        return view("pages.runs.show", compact(
            "run",
        ));
    }

    public function runStart(Task $task)
    {
        $run = Run::create([
            "task_id" => $task->id,
            "started_at" => now(),
        ]);
        return redirect()->route("runs.show", ["run" => $run])->with("toast", ["success", "Sesja rozpoczęta"]);
    }

    public function runFinish(Run $run)
    {
        $run->update([
            "finished_at" => now(),
            "hours_spent" => round(now()->diffInHours($run->started_at, true), 2),
        ]);
        return redirect()->route("tasks.show", ["task" => $run->task])->with("toast", ["success", "Sesja zakończona"]);
    }
    #endregion
}
