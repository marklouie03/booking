<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class PublishRate extends Eloquent{
    protected $table = 'published_rate';

    public function passenger() {
        return $this->belongsTo(Passenger::class, 'passenger_type_id');
    }
}