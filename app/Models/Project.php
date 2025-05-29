<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;

class Project extends Model
{
    use Userstamps;

    protected $fillable = [
        "name",
        "description",
        "logo_url",
        "client_id",
        "default_rate_id",
    ];

    #region relations
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function defaultRate()
    {
        return $this->belongsTo(Rate::class, "default_rate_id");
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }

    public function tasks()
    {
        return $this->hasManyThrough(ProjectTask::class, Area::class);
    }
    #endregion
}
