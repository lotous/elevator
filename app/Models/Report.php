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

    /**
     * Return get elevator
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function elevator()
    {
        return $this->hasOne(Elevator::class, 'id', 'elevator_id');
    }


}
