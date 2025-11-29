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

class Project extends Model
{
    //

    public const META = [
        "label" => "Projekty",
        "icon" => "castle",
        "description" => "...",
        "role" => "technical|client",
        "ordering" => 12,
    ];

    use SoftDeletes, Userstamps;

    protected $fillable = [
        "name",
        "client_id",
        "description",
        "logo_url",
        "color",
        "page_url",
        "repo_url",
    ];

    #region presentation
    public function __toString(): string
    {
        return $this->name;
    }

    public function optionLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => implode(" | ", [
                $this->client->name,
                $this->name,
            ]),
        );
    }

    public function displayTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => view("components.shipyard.app.h", [
                "lvl" => 3,
                "icon" => $this->icon ?? self::META["icon"],
                "attributes" => new ComponentAttributeBag([
                    "role" => "card-title",
                    "style" => "color: {$this->color};",
                ]),
                "slot" => $this->name,
            ])->render(),
        );
    }

    public function displaySubtitle(): Attribute
    {
        return Attribute::make(
            get: fn () => view("components.shipyard.app.model.badges", [
                "badges" => $this->badges,
            ])->render(),
        );
    }

    public function displayMiddlePart(): Attribute
    {
        return Attribute::make(
            get: fn () => view("components.shipyard.app.model.connections-preview", [
                "connections" => self::getConnections(),
                "model" => $this,
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
        "logo_url" => [
            "type" => "url",
            "label" => "Logo",
            "icon" => "image",
        ],
        "color" => [
            "type" => "color",
            "label" => "Kolor",
            "icon" => "palette",
        ],
        "page_url" => [
            "type" => "url",
            "label" => "Link do aplikacji",
            "icon" => "link",
        ],
        "repo_url" => [
            "type" => "url",
            "label" => "Link do repozytorium",
            "icon" => "file-link",
        ],
    ];

    public const CONNECTIONS = [
        "client" => [
            "model" => Client::class,
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

    public function scopeForConnection($query)
    {
        return $query->orderBy("name");
    }
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
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function scopes()
    {
        return $this->hasMany(Scope::class);
    }

    public function activeTasks()
    {
        return $this->hasManyThrough(Task::class, Scope::class)
            ->whereHas("status", fn ($q) => $q->where("statuses.name", "<>", "wdrożone"))
            ->ordered();
    }
    #endregion

    #region helpers
    #endregion
}
