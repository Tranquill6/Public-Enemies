<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    use HasFactory;
    
    //sets the table the model uses
    protected $table = "ranks";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'rank_value',
        'required_exp',
        'required_hq',
        'requires_owning_hq',
        'auto_promote',
        'special_requirements',
    ];
}
