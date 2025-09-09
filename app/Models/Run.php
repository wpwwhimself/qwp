<?php

namespace App\Models;

use App\Traits\Shipyard\HasStandardAttributes;
use App\Traits\Shipyard\HasStandardFields;
use App\Traits\Shipyard\HasStandardScopes;
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
        "name",
        "task_id",
        "description",
        "started_at",
        "finished_at",
        "hours_spent",
    ];

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
            //
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
    #endregion

    #region relations
    #endregion

    #region helpers
    #endregion
}
