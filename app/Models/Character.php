<?php

namespace App\Models;

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
        'name',
        'user_id',
        'city',
        'rank',
        'sex',
        'attackMultiplier',
        'defenseMultiplier',
        'intellectMultiplier',
        'stealthMultiplier',
        'enduranceMultiplier'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function city() {
        return $this->belongsTo(City::class, 'city', 'name');
    }
}
