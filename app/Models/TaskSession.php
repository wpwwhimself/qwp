<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;

class TaskSession extends Model
{
    use Userstamps;

    protected $fillable = [
        "task_id",
        "hours",
        "is_open",
    ];

    protected function casts(): array
    {
        return [
            "is_open" => "boolean",
        ];
    }

    #region relations
    public function task()
    {
        return $this->belongsTo(ProjectTask::class);
    }
    #endregion
}
