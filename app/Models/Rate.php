<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;

class Rate extends Model
{
    use Userstamps;

    protected $fillable = [
        "name",
        "description",
        "color",
        "mode",
        "amount",
    ];

    #region relations
    public function tasks()
    {
        return $this->hasMany(ProjectTask::class);
    }
    #endregion
}
