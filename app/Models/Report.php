<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'current_time',
        'sequence_id',
        'elevator_id',
        'start_floor_id',
        'end_floor_id',
        'floor_traveled',
    ];


    /**
     * Return get sequence
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sequence()
    {
        return $this->hasOne(Sequence::class);
    }

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

    /**
     * Return get elevator
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function elevator()
    {
        return $this->hasOne(Elevator::class);
    }


}
