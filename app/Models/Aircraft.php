<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    protected $table = 'aircraft';

    public function hub()
    {
        return $this->belongsTo('App\Models\Hub');
    }

    public function location()
    {
        return $this->belongsTo('App\Models\Airport');
    }

    public function airline()
    {
        return $this->belongsTo('App\Models\Airline');
    }

    public function aircraft_group()
    {
        return $this->belongsToMany('App\Models\AircraftGroup', 'aircraft_group_pivot');
    }

    public function type_rating()
    {
        return $this->belongsTo('App\Models\TypeRating');
    }

    public function flights()
    {
        return $this->hasMany('App\Models\Flight');
    }

    public function isAvailable()
    {
        $active = $this->flights()->filed()->active()->get();
        if ($active->isEmpty()) {
            return true;
        }

        return false;
    }
}
