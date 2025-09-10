<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class TaskMgmtController extends Controller
{
    public function clients()
    {
        $clients = Client::withCount("projects")
            ->withCount("user")
            ->paginate(25);

        return view("pages.clients.list", compact(
            "clients",
        ));
    }
}
