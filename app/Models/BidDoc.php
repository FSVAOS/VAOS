<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BidDoc
 *
 * @mixin \Eloquent
 */
class BidDoc extends Model
{
    protected $fillable = [];

    public function bid()
    {
        return $this->belongsTo('App\Models\Bid');
    }
}
