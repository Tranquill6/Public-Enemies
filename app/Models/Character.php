<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;

    //table for the model
    protected $table = 'characters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'description',
        'name',
        'rank_value',
        'user_id',
        'city',
        'rank',
        'sex',
        'lastActive',
        'money',
        'attackMultiplier',
        'defenseMultiplier',
        'intellectMultiplier',
        'stealthMultiplier',
        'enduranceMultiplier'
    ];

     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'diedAt',
        'jailExpiresAt',
        'lastActive'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'lastActive' => 'datetime'
    ];

    public function setLastActiveAttributes($value) {
        $this->attributes['lastActive'] = strtolower($value);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function city() {
        return $this->belongsTo(City::class, 'city', 'name');
    }

    public function timers() {
        return $this->hasMany(Timer::class);
    }

    public function rank() {
        return $this->belongsTo(Rank::class, 'rank', 'name');
    }
}
