<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    protected $fillable = [
        'name', 'serving_size', 'calories', 'carbohydrates', 'sugar', 'fibre', 'fat', 'saturated_fat', 'protein',
        'sodium', 'user_id',
    ];

    public function consumptions()
    {
        return $this->hasMany(Consumption::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCarbohydratesStringAttribute()
    {
        if ($this->carbohydrates != null) {
            return $this->carbohydrates.'g';
        } else {
            return 'NA';
        }
    }

    public function getSugarStringAttribute()
    {
        if ($this->sugar != null) {
            return $this->sugar.'g';
        } else {
            return 'NA';
        }
    }

    public function getFibreStringAttribute()
    {
        if ($this->fibre != null) {
            return $this->fibre.'g';
        } else {
            return 'NA';
        }
    }

    public function getFatStringAttribute()
    {
        if ($this->fat != null) {
            return $this->fat.'g';
        } else {
            return 'NA';
        }
    }

    public function getSaturatedFatStringAttribute()
    {
        if ($this->saturated_fat != null) {
            return $this->saturated_fat.'g';
        } else {
            return 'NA';
        }
    }

    public function getProteinStringAttribute()
    {
        if ($this->protein != null) {
            return $this->protein.'g';
        } else {
            return 'NA';
        }
    }

    public function getSodiumStringAttribute()
    {
        if ($this->sodium != null) {
            return $this->sodium.'mg';
        } else {
            return 'NA';
        }
    }

    public function scopeFilter($query, $params)
    {
        if (isset($params['search']) && trim($params['search']) !== '') {
            $query->where('name', 'LIKE', '%'.str_replace(' ', '%', trim($params['search'])).'%');
        }

        return $query;
    }

    public function scopeOrder($query, $params)
    {
        if (isset($params['sort']) && $params['sort'] === 'name-desc') {
            $query->orderByRaw('name COLLATE NOCASE DESC');
        } else {
            $query->orderByRaw('name COLLATE NOCASE');
        }
    }
}
