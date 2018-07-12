<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeRating extends Model
{
    public function user()
    {
        return $this->belongsToMany('App\User');
    }

    public function airline()
    {
        return $this->belongsTo('App\Models\Airline');
    }

    public function aircraft()
    {
        return $this->belongsToMany('App\Models\Aircraft');
    }

    public function aircraft_groups()
    {
        return $this->belongsToMany('App\Models\AircraftGroup');
    }
}
