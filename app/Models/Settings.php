<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'timezone', 'gender', 'age', 'height', 'calorie_target', 'goal_weight', 'user_id',
    ];

    protected $casts = [
        'birthday' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAgeAttribute()
    {
        return $this->localised_date->diffInYears($this->birthday);
    }

    public function getLocalisedDateAttribute()
    {
        return Carbon::today($this->timezone);
    }

    public function getLocalisedDateStringAttribute()
    {
        if ($this->localised_date !== null) {
            return $this->localised_date->format('Y-m-d');
        } else {
            return;
        }
    }
}
