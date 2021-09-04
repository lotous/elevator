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
    public function startFloor()
    {
        return $this->hasOne(Floor::class, 'start_floor_id');
    }

    /**
     * Return get end floor
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function endFloor()
    {
        return $this->hasOne(Floor::class, 'end_floor_id');
    }

}
