<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crime extends Model
{
    use HasFactory;
    
    //sets the table the model uses
    protected $table = "crimes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'rank_required',
        'gives_exp',
        'gives_attack',
        'gives_defense',
        'gives_intelliect',
        'gives_stealth',
        'gives_endurance',
    ];
}
