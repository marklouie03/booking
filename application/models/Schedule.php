<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Schedule extends Eloquent{
    protected $table = 'schedule';

    public function vessel() {
        return $this->belongsTo(Vessel::class);
    }

    public function route() {
        return $this->belongsTo(Route::class);
    }
}