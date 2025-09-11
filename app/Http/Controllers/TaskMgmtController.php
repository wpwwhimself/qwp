<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Run;
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
        return view("pages.projects.show", compact(
            "project",
        ));
    }
    #endregion

    #region tasks
    public function tasks()
    {
        abort(501);
    }

    public function task(Task $task)
    {
        return view("pages.tasks.show", compact(
            "task",
        ));
    }

    public function taskRestatus(Task $task, int $new_status_index)
    {
        $task->update([
            "status_id" => Status::where("index", $new_status_index)->first()->id,
        ]);
        return back()->with("toast", ["success", "Status zmieniony"]);
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
