<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Consumption extends Model
{
    protected $fillable = [
        'consumed_at', 'amount', 'food_id', 'user_id',
    ];

    protected $casts = [
        'consumed_at' => 'date',
    ];

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getConsumedAtStringAttribute()
    {
        return $this->consumed_at->format('d F Y');
    }

    public function getAmountStringAttribute()
    {
        return $this->amount.'g/ml';
    }

    public function getCaloriesAttribute()
    {
        if ($this->food->calories !== null) {
            return round($this->food->calories / 100 * $this->amount, 1);
        } else {
            return;
        }
    }

    public function getCarbohydratesAttribute()
    {
        if ($this->food->carbohydrates !== null) {
            return round($this->food->carbohydrates / 100 * $this->amount, 1);
        } else {
            return;
        }
    }

    public function getSugarAttribute()
    {
        if ($this->food->sugar !== null) {
            return round($this->food->sugar / 100 * $this->amount, 1);
        } else {
            return;
        }
    }

    public function getFibreAttribute()
    {
        if ($this->food->fibre !== null) {
            return round($this->food->fibre / 100 * $this->amount, 1);
        } else {
            return;
        }
    }

    public function getFatAttribute()
    {
        if ($this->food->fat !== null) {
            return round($this->food->fat / 100 * $this->amount, 1);
        } else {
            return;
        }
    }

    public function getSaturatedFatAttribute()
    {
        if ($this->food->saturated_fat !== null) {
            return round($this->food->saturated_fat / 100 * $this->amount, 1);
        } else {
            return;
        }
    }

    public function getProteinAttribute()
    {
        if ($this->food->protein !== null) {
            return round($this->food->protein / 100 * $this->amount, 1);
        } else {
            return;
        }
    }

    public function getSodiumAttribute()
    {
        if ($this->food->sodium !== null) {
            return round($this->food->sodium / 100 * $this->amount, 1);
        } else {
            return;
        }
    }

    public function getCarbohydratesStringAttribute()
    {
        if ($this->carbohydrates !== null) {
            return $this->carbohydrates.'g';
        } else {
            return 'NA';
        }
    }

    public function getSugarStringAttribute()
    {
        if ($this->sugar !== null) {
            return $this->sugar.'g';
        } else {
            return 'NA';
        }
    }

    public function getFibreStringAttribute()
    {
        if ($this->fibre !== null) {
            return $this->fibre.'g';
        } else {
            return 'NA';
        }
    }

    public function getFatStringAttribute()
    {
        if ($this->fat !== null) {
            return $this->fat.'g';
        } else {
            return 'NA';
        }
    }

    public function getSaturatedFatStringAttribute()
    {
        if ($this->saturated_fat !== null) {
            return $this->saturated_fat.'g';
        } else {
            return 'NA';
        }
    }

    public function getProteinStringAttribute()
    {
        if ($this->protein !== null) {
            return $this->protein.'g';
        } else {
            return 'NA';
        }
    }

    public function getSodiumStringAttribute()
    {
        if ($this->sodium !== null) {
            return $this->sodium.'mg';
        } else {
            return 'NA';
        }
    }

    public function scopeFilter($query, $params)
    {
        if (isset($params['search']) && trim($params['search']) !== '') {
            $query->whereHas('food', function ($q) use ($params) {
                $q->where('name', 'LIKE', '%'.str_replace(' ', '%', trim($params['search'])).'%');
            });
        }

        if (isset($params['search']) && strtotime(trim($params['search']))) {
            Carbon::parse(trim($params['search']));

            $query->orWhere('consumed_at', Carbon::parse(trim($params['search'])));
        }

        return $query;
    }

    public function scopeOrder($query, $params)
    {
        if (isset($params['sort']) && $params['sort'] === 'date-asc') {
            $query->orderBy('consumed_at', 'asc');
        } else {
            $query->orderByDesc('consumed_at');
        }
    }
}
