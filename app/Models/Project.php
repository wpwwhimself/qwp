<?php

namespace App\Models;

use Wpwwhimself\Shipyard\Traits\HasStandardAttributes;
use Wpwwhimself\Shipyard\Traits\HasStandardFields;
use Wpwwhimself\Shipyard\Traits\HasStandardScopes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\ComponentAttributeBag;
use Mattiverse\Userstamps\Traits\Userstamps;

class Project extends Model
{
    //

    public const META = [
        "label" => "Projekty",
        "icon" => "castle",
        "description" => "Lista projektów, jakie zostały stworzone.",
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
            get: fn () => view("shipyard::components.app.h", [
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
            get: fn () => null,
        );
    }

    public function displayPreTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->logo_url)
                ? "<img class='logo' src='$this->logo_url' alt='$this->name' />"
                : null,
        );
    }

    public function displayMiddlePart(): Attribute
    {
        return Attribute::make(
            get: fn () => view("shipyard::components.app.model.connections-preview", [
                "connections" => self::getConnections(),
                "model" => $this,
            ])->render(),
        );
    }
    #endregion

    #region fields
    use HasStandardFields;

    public const FIELDS = [
        "name" => [
            "role" => "technical",
        ],
        "description" => [
            "type" => "TEXT",
            "label" => "Opis",
            "icon" => "text",
            "role" => "technical",
        ],
        "logo_url" => [
            "type" => "url",
            "label" => "Logo",
            "icon" => "image",
            "role" => "technical",
        ],
        "color" => [
            "type" => "color",
            "label" => "Kolor",
            "icon" => "palette",
            "role" => "technical",
        ],
        "page_url" => [
            "type" => "url",
            "label" => "Link do aplikacji",
            "icon" => "link",
            "role" => "technical",
        ],
        "repo_url" => [
            "type" => "url",
            "label" => "Link do repozytorium",
            "icon" => "file-link",
            "role" => "technical",
        ],
    ];

    public const CONNECTIONS = [
        "client" => [
            "model" => Client::class,
            "mode" => "one",
            "role" => "technical",
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

    public function roleRules(): array
    {
        return [
            "client" => $this->client_id == Auth::user()?->client->id,
        ];
    }
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
