<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
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
}
