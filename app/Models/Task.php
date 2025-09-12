<?php

namespace App\Models;

use App\Traits\Shipyard\HasStandardAttributes;
use App\Traits\Shipyard\HasStandardFields;
use App\Traits\Shipyard\HasStandardScopes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
        "rate_id",
        "rate_value",
    ];

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

    #region fields
    use HasStandardFields;

    public const FIELDS = [
        "description" => [
            "type" => "TEXT",
            "label" => "Opis",
            "icon" => "text",
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

    public function scopeActive($query): void
    {
        $query->where("status_id", "!=", Status::final()->id);
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

    public function totalHoursSpent(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->runs()->sum("hours_spent"),
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
        return $this->hasMany(Run::class);
    }
    #endregion

    #region helpers
    #endregion
}
