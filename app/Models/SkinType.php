<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkinType extends Model
{
    protected $fillable = ['skin_type', 'description'];

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}