<?php

use App\Http\Controllers\TaskMgmtController;
use Illuminate\Support\Facades\Route;

if (file_exists(__DIR__.'/Shipyard/shipyard.php')) require __DIR__.'/Shipyard/shipyard.php';

Route::redirect("/", "profile");

Route::middleware("auth")->group(function () {
    Route::controller(TaskMgmtController::class)->group(function () {
        Route::get("clients", "clients")->name("clients.list");
        Route::get("clients/{client}/stats", "clientStats")->name("clients.stats");

        Route::get("projects", "projects")->name("projects.list");
        Route::get("projects/{project}", "project")->name("projects.show");

        Route::get("tasks", "tasks")->name("tasks.list");
        Route::get("tasks/{task}", "task")->name("tasks.show");
        Route::get("tasks/{task}/stats", "taskStats")->name("tasks.stats");
    });
});
