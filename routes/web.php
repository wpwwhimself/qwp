<?php

use App\Http\Controllers\TaskMgmtController;
use App\Http\Middleware\EnsureClientOwnsProject;
use Wpwwhimself\Shipyard\Middleware\EnsureUserHasRole;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "profile");

Route::middleware("auth")->group(function () {
    Route::controller(TaskMgmtController::class)->group(function () {
        Route::prefix("clients")->group(function () {
            Route::get("", "clients")->name("clients.list");
            Route::get("my-stats", "clientStatsForClient")->name("clients.stats-for-client")->middleware(EnsureUserHasRole::class.":client");
            Route::get("{client}", "client")->name("clients.show");
            Route::get("{client}/stats", "clientStats")->name("clients.stats");
            Route::get("{client}/monthly-summary/{month}", "clientMonthlySummary")->name("clients.monthly-summary");
            Route::get("{client}/monthly-summary/{month}/download", "clientMonthlySummaryDownload")->name("clients.monthly-summary.download");
        });

        Route::prefix("projects")->group(function () {
            Route::get("{project}", "project")->name("projects.show");
        });

        Route::prefix("scopes")->group(function () {
            Route::get("{scope}", "scope")->name("scopes.show");
            Route::post("create", "scopeCreate")->name("scopes.create");
        });

        Route::prefix("tasks")->group(function () {
            Route::get("", "tasks")->name("tasks.list");
            Route::get("{task}", "task")->name("tasks.show");
            Route::get("{task}/stats", "taskStats")->name("tasks.stats");
            Route::get("{task}/restatus/{new_status_index}", "taskRestatus")->name("tasks.restatus");
            Route::post("create", "taskCreate")->name("tasks.create");
            Route::post("append-to-description", "taskAppendToDescription")->name("tasks.append-to-description");
        });

        Route::prefix("runs")->group(function () {
            Route::get("", "runs")->name("runs.list");
            Route::post("edit", "runEdit")->name("runs.edit");
            Route::get("{run}", "run")->name("runs.show");

            Route::prefix("manage")->group(function () {
                Route::get("start/{task}", "runStart")->name("runs.start");
                Route::get("finish/{run}", "runFinish")->name("runs.finish");
            });
        });
    });
});
