<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'action',
        'label',
        'value',
        'category_id',
    ];

    // Beziehung zur Kategorie
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
