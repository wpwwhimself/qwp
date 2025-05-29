<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $fillable = [
        "name",
        "description",
        "icon",
        "project_id",
    ];

    #region relations
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }
    #endregion
}
