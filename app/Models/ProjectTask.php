<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;

class ProjectTask extends Model
{
    use Userstamps;

    protected $fillable = [
        "name",
        "description",
        "area_id",
        "status_id",
    ];

    #region relations
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function status()
    {
        return $this->belongsTo(ProjectTaskStatus::class);
    }

    public function sessions()
    {
        return $this->hasMany(TaskSession::class);
    }
    #endregion
}
