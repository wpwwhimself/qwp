<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;

class ProjectTaskStatus extends Model
{
    use Userstamps;

    protected $fillable = [
        "name",
        "description",
        "icon",
        "color",
    ];

    #region relations
    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }
    #endregion
}
