<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    protected $fillable = [
        'date', 'weight', 'user_id',
    ];

    protected $dates = [
        'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDateStringAttribute()
    {
        return $this->date->format('d F Y');
    }

    public function getWeightStringAttribute()
    {
        return $this->weight.'kg';
    }

    public function getDifferenceStringAttribute()
    {
        if ($this->difference !== null) {
            return $this->difference.'kg';
        } else {
            return 'NA';
        }
    }
}
