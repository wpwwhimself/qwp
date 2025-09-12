<?php

namespace App\Models;

use App\Traits\Shipyard\HasStandardAttributes;
use App\Traits\Shipyard\HasStandardFields;
use App\Traits\Shipyard\HasStandardScopes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Run extends Model
{
    //

    public const META = [
        "label" => "Sesje",
        "icon" => "run",
        "description" => "Pojedyncze posiedzenia przy pracy.",
        "role" => "technical",
        "ordering" => 15,
    ];

    use SoftDeletes, Userstamps;

    protected $fillable = [
        "task_id",
        "description",
        "started_at",
        "finished_at",
        "hours_spent",
    ];

    public function __toString(): string
    {
        return ($this->is_finished ? "ukończona" : "w toku")
            . " ("
            . $this->started_at->format("Y-m-d H:i")
            . ", "
            . $this->hours_spent
            . " h)";
    }

    public function optionLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->is_finished ? "ukończona" : "w toku")
                . " ("
                . $this->started_at->format("Y-m-d H:i")
                . ", "
                . $this->hours_spent
                . " h)",
        );
    }

    #region fields
    use HasStandardFields;

    public const FIELDS = [
        "description" => [
            "type" => "TEXT",
            "label" => "Opis",
            "icon" => "text",
        ],
        "started_at" => [
            "type" => "datetime-local",
            "label" => "Czas rozpoczęcia",
            "icon" => "clock",
        ],
        "finished_at" => [
            "type" => "datetime-local",
            "label" => "Czas zakończenia",
            "icon" => "clock",
        ],
        "hours_spent" => [
            "type" => "number",
            "label" => "Poświęcono godzin",
            "icon" => "timer",
            "required" => true,
            "min" => 0,
            "step" => 0.01,
        ],
    ];

    public const CONNECTIONS = [
        "task" => [
            "model" => Task::class,
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
    #endregion

    #region attributes
    protected function casts(): array
    {
        return [
            "started_at" => "datetime",
            "finished_at" => "datetime",
        ];
    }

    use HasStandardAttributes;

    // public function badges(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn () => [
    //             [
    //                 "label" => "",
    //                 "icon" => "",
    //                 "class" => "",
    //                 "condition" => "",
    //             ],
    //         ],
    //     );
    // }

    public function isFinished(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->finished_at !== null,
        );
    }
    #endregion

    #region relations
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
    #endregion

    #region helpers
    #endregion
}
