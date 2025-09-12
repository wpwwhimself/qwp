<?php

namespace App\Models;

use App\Traits\Shipyard\HasStandardAttributes;
use App\Traits\Shipyard\HasStandardFields;
use App\Traits\Shipyard\HasStandardScopes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Status extends Model
{
    //

    public const META = [
        "label" => "Statusy",
        "icon" => "timeline",
        "description" => "Statusy zadań projektów.",
        "role" => "technical",
        "ordering" => 2,
    ];

    use SoftDeletes, Userstamps;

    protected $fillable = [
        "name",
        "icon",
        "color",
        "index",
    ];

    public function __toString(): string
    {
        return view("components.statuses.tile", ["status" => $this])->render();
    }

    public function optionLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->name,
        );
    }

    #region fields
    use HasStandardFields;

    public const FIELDS = [
        "icon" => [
            "type" => "icon",
            "label" => "Ikona",
            "icon" => "image",
            "required" => true,
        ],
        "color" => [
            "type" => "color",
            "label" => "Kolor",
            "icon" => "palette",
            "required" => true,
        ],
        "index" => [
            "type" => "number",
            "label" => "Kolejność",
            "icon" => "sort",
            "required" => true,
        ],
    ];

    public const CONNECTIONS = [
        // "<name>" => [
        //     "model" => ,
        //     "mode" => "<one|many>",
        // ],
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
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    #endregion

    #region helpers
    public static function maxIndex(): int
    {
        return self::max("index");
    }

    public static function final(): self
    {
        return self::where("index", self::maxIndex())->first();
    }
    #endregion
}
