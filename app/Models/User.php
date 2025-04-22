<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email', 'password'];
    protected $hidden = ['password'];

    public function apiKey()
    {
        return $this->hasOne(ApiKey::class);
    }
}

