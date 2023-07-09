<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keys extends Model
{
    use HasFactory;
    use HasUuids;

    protected $uuidFieldName = 'key';
    public $incrementing = false;
    protected $keyType = 'string';
    protected bool $primaryKeyIsUuid = true;
    protected $primaryKey = 'key';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'used',
    ];
}
