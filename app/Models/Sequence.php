<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'start_time',
        'end_time',
        'start_floor_id',
        'end_floor_id',
        'latency'
    ];

    /**
     * Return get start floor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function start_floor()
    {
        return $this->hasOne(Floor::class, 'id', 'start_floor_id');
    }

    /**
     * Return get end floor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function end_floor()
    {
        return $this->hasOne(Floor::class, 'id', 'end_floor_id');
    }

}
