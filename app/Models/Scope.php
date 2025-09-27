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

class Scope extends Model
{
    public const META = [
        "label" => "Zakresy",
        "icon" => "inbox-multiple",
        "description" => "Opisują moduły aplikacji, w których przeprowadzane są prace.",
        "role" => "",
        "ordering" => 13,
    ];

    use SoftDeletes, Userstamps;

    protected $fillable = [
        "name",
        "project_id",
        "description",
        "icon",
    ];

    #region presentation
    public function __toString(): string
    {
        return implode(" | ", [
            $this->project->name,
            $this->name,
        ]);
    }

    public function optionLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => implode(" | ", [
                $this->project->client->name,
                $this->project->name,
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
        "icon" => [
            "type" => "icon",
            "label" => "Ikona",
            "icon" => "image",
        ],
    ];

    public const CONNECTIONS = [
        "project" => [
            "model" => Project::class,
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
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->ordered();
    }

    public function activeTasks()
    {
        return $this->tasks()->active();
    }
    #endregion

    #region helpers
    #endregion
}
