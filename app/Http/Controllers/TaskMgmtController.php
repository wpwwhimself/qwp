<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Run;
use App\Models\Scope;
use App\Models\Status;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Accounting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Currency;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat\Wizard\Number;

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

    public function client(Client $client)
    {
        abort(501);
    }

    public function clientStats(Client $client)
    {
        $sections = [
            ["label" => "Status projektów", "id" => "projects", "icon" => model_icon("projects")],
            ["label" => "Nakład prac", "id" => "runs", "icon" => model_icon("runs")],
        ];

        return view("pages.clients.stats", compact(
            "client",
            "sections",
        ));
    }

    public function clientStatsForClient()
    {
        $client = Client::where("user_id", Auth::id())->first();
        if (!$client) {
            return back()->with("toast", ["error", "Musisz być klientem, żeby zobaczyć statystyki"]);
        }

        return redirect()->route("clients.stats", ["client" => $client]);
    }

    private function getMonthlySummaryData(Client $client, $month)
    {
        return $client->runs_by_month->get($month);
    }

    public function clientMonthlySummary(Client $client, $month)
    {
        $runs_this_month = $this->getMonthlySummaryData($client, $month);
        $data = $runs_this_month->groupBy([
            fn ($r) => $r->task->scope->project_id,
            fn ($r) => $r->task->scope_id,
            fn ($r) => $r->task_id,
        ]);

        return view("pages.clients.monthly-summary", compact(
            "month",
            "client",
            "runs_this_month",
            "data",
        ));
    }

    public function clientMonthlySummaryDownload(Client $client, $month)
    {
        $data = $this->getMonthlySummaryData($client, $month)
            ->groupBy("task_id")
            ->map(function ($runs) use ($month) {
                $exemplar = $runs->first();
                return[
                    "project" => $exemplar->task->scope->project,
                    "scope" => $exemplar->task->scope,
                    "task" => $exemplar->task,
                    "started_at" => $exemplar->started_at->format("Y-m-d"),
                    "hours_spent" => $runs->sum("hours_spent"),
                    "status" => $exemplar->task->status,
                    "finished_at" => $exemplar->task->is_finished ? $exemplar->finished_at->format("Y-m-d") : null,
                    "cost" => $exemplar->task->cost->get($month),
                ];
            })
            ->sortBy([
                "project.name",
                "scope.name",
                "task.created_at",
            ]);

        $title = "Podsumowanie miesięczne prac - ". Carbon::parse($month)->format("m.Y");

        $document = new Spreadsheet();
        $worksheet = $document->getActiveSheet();

        $worksheet->setCellValue([1, 1], $title);
        $worksheet->mergeCells([1, 1, 6, 1]);
        $worksheet->setCellValue([7, 1], "wynagrodzenie łączne");
        $worksheet->setCellValue([8, 1], $data->sum("cost"));
        $worksheet->getRowDimension(1)->setRowHeight(30);

        $worksheet->setCellValue([1, 2], "Projekt");
        $worksheet->setCellValue([2, 2], "Zakres");
        $worksheet->setCellValue([3, 2], "Zadanie");
        $worksheet->setCellValue([4, 2], "Data przyjęcia");
        $worksheet->setCellValue([5, 2], "Czas poświęcony [h]");
        $worksheet->setCellValue([6, 2], "Status");
        $worksheet->setCellValue([7, 2], "Data wdrożenia");
        $worksheet->setCellValue([8, 2], "Wynagrodzenie");

        $row_id = 3;
        foreach ($data as $task_data) {
            $worksheet->setCellValue([1, $row_id], $task_data["project"]->name);
            $worksheet->setCellValue([2, $row_id], $task_data["scope"]->name);
            $worksheet->setCellValue([3, $row_id], $task_data["task"]->name);
            $worksheet->setCellValue([4, $row_id], $task_data["started_at"]);
            $worksheet->setCellValue([5, $row_id], $task_data["hours_spent"]);
            $worksheet->setCellValue([6, $row_id], $task_data["status"]->name);
            $worksheet->setCellValue([7, $row_id], $task_data["finished_at"]);
            $worksheet->setCellValue([8, $row_id], $task_data["cost"]);
            $row_id++;
        }

        $hrs = new Currency("h", currencySymbolPosition: Currency::TRAILING_SYMBOL, currencySymbolSpacing: Currency::SYMBOL_WITH_SPACING);
        $worksheet->getStyle("E:E")->getNumberFormat()->setFormatCode($hrs);
        $pln = new Accounting("zł", currencySymbolPosition: Currency::TRAILING_SYMBOL, currencySymbolSpacing: Currency::SYMBOL_WITH_SPACING);
        $worksheet->getStyle("H:H")->getNumberFormat()->setFormatCode($pln);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$title.'.xlsx"');
        IOFactory::createWriter($document, "Xlsx")
            ->save("php://output");
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
        $statuses = Status::ordered()->get()
            ->filter(fn ($s) => $s->id != Status::final()->id);
        $tasks = Task::ordered()
            ->get()
            ->groupBy("status_id");

        $activeRun = Run::whereNull("finished_at")->first();

        return view("pages.tasks.list", compact(
            "statuses",
            "tasks",
            "activeRun",
        ));
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
            "priority" => $rq->priority ?? 3,
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
        return back()->with("toast", ["success", "Sesja rozpoczęta"]);
    }

    public function runFinish(Run $run)
    {
        $run->update([
            "finished_at" => now(),
            "hours_spent" => round(now()->diffInHours($run->started_at, true), 2),
        ]);
        return back()->with("toast", ["success", "Sesja zakończona"]);
    }
    #endregion
}
