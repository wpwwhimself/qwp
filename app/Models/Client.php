<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Mattiverse\Userstamps\Traits\Userstamps;

class Client extends Model
{
    use Userstamps;

    protected $fillable = [
        "name",
        "description",
        "logo_url",
        "address",
    ];

    #region relations
    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    #endregion
}
