<?php

namespace App\Models;

use App\Traits\Shipyard\HasStandardAttributes;
use App\Traits\Shipyard\HasStandardFields;
use App\Traits\Shipyard\HasStandardScopes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\View\ComponentAttributeBag;
use Mattiverse\Userstamps\Traits\Userstamps;

class Task extends Model
{
    //

    public const META = [
        "label" => "Zadania",
        "icon" => "check-circle",
        "description" => "Zadania do wykonania w określonym module.",
        "role" => "",
        "ordering" => 14,
    ];

    use SoftDeletes, Userstamps;

    protected $fillable = [
        "name",
        "scope_id",
        "description",
        "status_id",
        "priority",
        "rate_id",
        "rate_value",
    ];

    #region presentation
    public function __toString(): string
    {
        return implode(" | ", [
            $this->scope->project->name,
            $this->scope->name,
            $this->name,
        ]);
    }

    public function optionLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => implode(" | ", [
                $this->scope->project->name,
                $this->scope->name,
                $this->name,
            ]),
        );
    }

    public function displayTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => "<div class='flex right nowrap middle' role='card-title'>"
            . view("components.shipyard.app.icon", [
                "name" => "numeric-$this->priority-circle",
            ])->render()
            . "<strong>$this->name</strong>"
            . "</div>",
        );
    }

    public function displaySubtitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->scope,
        );
    }

    public function displayMiddlePart(): Attribute
    {
        return Attribute::make(
            get: fn () => view("components.shipyard.app.model.connections-preview", [
                "connections" => array_filter(self::getConnections(), fn ($n) => $n != "scope", ARRAY_FILTER_USE_KEY),
                "model" => $this,
            ])->render()
            . view("components.shipyard.app.icon-label-value", [
                "icon" => "timer",
                "label" => "Łączny czas poświęcony",
                "slot" => "$this->total_hours_spent h",
            ])->render(),
        );
    }
    #endregion

    #region fields
    use HasStandardFields;

    public const FIELDS = [
        "description" => [
            "type" => "TEXT",
            "label" => "Opis",
            "icon" => "text",
        ],
        "priority" => [
            "type" => "select",
            "select-data" => [
                "options" => [
                    ["value" => 1, "label" => "1 - krytyczny",],
                    ["value" => 2, "label" => "2 - wysoki",],
                    ["value" => 3, "label" => "3 - normalny",],
                    ["value" => 4, "label" => "4 - niski",],
                    ["value" => 5, "label" => "5 - może kiedyś",],
                ],
            ],
            "label" => "Priorytet",
            "icon" => "priority-high",
        ],
        "rate_value" => [
            "type" => "number",
            "label" => "Wartość stawki",
            "icon" => "cash",
            "step" => 0.01,
            "min" => 0,
        ],
    ];

    public const CONNECTIONS = [
        "scope" => [
            "model" => Scope::class,
            "mode" => "one",
        ],
        "status" => [
            "model" => Status::class,
            "mode" => "one",
        ],
        "rate" => [
            "model" => Rate::class,
            "mode" => "one",
        ],
    ];

    public const ACTIONS = [
        // [
        //     "icon" => "",
        //     "label" => "",
        //     "show-on" => "<list|edit>",
        //     "route" => "",
        //     "role" => "",
        //     "dangerous" => true,
        // ],
    ];
    #endregion

    // use CanBeSorted;
    public const SORTS = [
        // "<name>" => [
        //     "label" => "",
        //     "compare-using" => "function|field",
        //     "discr" => "<function_name|field_name>",
        // ],
    ];

    public const FILTERS = [
        // "<name>" => [
        //     "label" => "",
        //     "icon" => "",
        //     "compare-using" => "function|field",
        //     "discr" => "<function_name|field_name>",
        //     "mode" => "<one|many>",
        //     "operator" => "",
        //     "options" => [
        //         "<label>" => <value>,
        //     ],
        // ],
    ];

    #region scopes
    use HasStandardScopes;

    public function scopeOrdered($query): void
    {
        $query->orderBy("priority")
            ->orderBy("created_at");
    }

    public function scopeActive($query): void
    {
        $query->ordered()->where("status_id", "!=", Status::final()->id);
    }

    public function scopePending($query): void
    {
        $query->ordered()->where("status_id", Status::where("index", 1)->first()->id);
    }
    #endregion

    #region attributes
    protected function casts(): array
    {
        return [
            //
        ];
    }

    protected $appends = [
        "total_hours_spent",
    ];

    use HasStandardAttributes;

    public function badges(): Attribute
    {
        return Attribute::make(
            get: fn () => [
                // [
                //     "html" => view("components.statuses.tile", [
                //         "status" => $this->status,
                //     ]),
                // ],
            ],
        );
    }

    public function totalHoursSpent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->runs()->sum("hours_spent"),
        );
    }

    public function isFinished(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->status_id == Status::final()->id,
        );
    }

    public function cost(): Attribute
    {
        return Attribute::make(
            get: function () {
                $runs_by_month = $this->runs->groupBy(fn ($r) => $r->started_at->format("Y-m"))->sortKeys();

                switch ($this->rate->mode) {
                    case 0: // jednorazowo
                        return $runs_by_month->mapWithKeys(fn ($rs, $m) => [$m => $m == $runs_by_month->firstKey() ? $this->rate_value : 0]);
                    case 1: // miesięcznie
                        return $runs_by_month->mapWithKeys(fn ($rs, $m) => [$m => null]); // podliczenie osobno ze wszystkimi zadaniami
                    case 2: // godzinowo
                        return $runs_by_month->mapWithKeys(fn ($rs, $m) => [$m => $this->rate_value * $rs->sum("hours_spent")]);
                }
            },
        );
    }
    #endregion

    #region relations
    public function scope()
    {
        return $this->belongsTo(Scope::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class);
    }

    public function runs()
    {
        return $this->hasMany(Run::class)
            ->orderByDesc("started_at");
    }
    #endregion

    #region helpers
    #endregion
}
