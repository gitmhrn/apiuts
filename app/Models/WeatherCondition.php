<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherCondition extends Model
{
    protected $fillable = ['weather_type', 'description'];

    public function recommendations()
    {
        return $this->hasMany(Recommendation::class);
    }
}