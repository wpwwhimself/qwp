<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTaskStatusNextStatus extends Model
{
    protected $fillable = [
        "from_status_id",
        "to_status_id",
    ];

    public $timestamps = false;

    #region relations
    public function fromStatus()
    {
        return $this->belongsTo(ProjectTaskStatus::class, "from_status_id");
    }

    public function toStatus()
    {
        return $this->belongsTo(ProjectTaskStatus::class, "to_status_id");
    }
    #endregion
}
