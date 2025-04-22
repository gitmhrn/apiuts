<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Recommendation extends Model
{
    protected $fillable = [
        'weather_condition_id',
        'skin_type_id',
        'skin_condition_id',
        'recommended_product_ids'
    ];

    public function weatherCondition()
    {
        return $this->belongsTo(WeatherCondition::class);
    }

    public function skinType()
    {
        return $this->belongsTo(SkinType::class);
    }

    public function skinCondition()
    {
        return $this->belongsTo(SkinCondition::class);
    }

    public function recommendedProducts()
    {
        $ids = explode(',', $this->recommended_product_ids);
        return Product::whereIn('id', $ids)->get();
    }
}
