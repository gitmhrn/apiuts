<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkinCondition extends Model
{
    protected $fillable = ['condition_type', 'description'];

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}