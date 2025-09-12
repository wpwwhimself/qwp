<?php

namespace App\Models;

use App\Models\Shipyard\User;
use App\Traits\Shipyard\HasStandardAttributes;
use App\Traits\Shipyard\HasStandardFields;
use App\Traits\Shipyard\HasStandardScopes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

class Client extends Model
{
    //

    public const META = [
        "label" => "Klienci",
        "icon" => "account-tie",
        "description" => "Lista klientów, z którymi współpracuję.",
        "role" => "technical",
        "ordering" => 11,
    ];

    use SoftDeletes, Userstamps;

    protected $fillable = [
        "name",
        "user_id",
        "full_name",
        "address",
        "default_rate_id",
        "default_rate_value",
    ];

    public function __toString(): string
    {
        return $this->name;
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
        "full_name" => [
            "type" => "text",
            "label" => "Pełna nazwa firmy",
            "icon" => "card-account-details",
            "required" => true,
        ],
        "address" => [
            "type" => "text",
            "label" => "Adres firmy",
            "icon" => "map-marker",
            "required" => true,
        ],
        "default_rate_value" => [
            "type" => "number",
            "label" => "Wartość stawki domyślnej",
            "icon" => "cash",
            "required" => true,
        ],
    ];

    public const CONNECTIONS = [
        "user" => [
            "model" => User::class,
            "mode" => "one",
        ],
        "rate" => [
            "model" => Rate::class,
            "mode" => "one",
            "field_name" => "default_rate_id",
            "field_label" => "Stawka domyślna",
        ],
    ];

    public const ACTIONS = [
        // [
        //     "icon" => "account-plus",
        //     "label" => "Dodaj użytkownika",
        //     "show-on" => "list",
        //     "route" => "admin.model.edit",
        //     "role" => "technical",
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
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rate()
    {
        return $this->belongsTo(Rate::class, "default_rate_id");
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    #endregion

    #region helpers
    #endregion
}
