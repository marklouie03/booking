<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Vessel extends Eloquent{

    public function seatSection() {
        return $this->hasMany(SeatSection::class);
    }

    public function bedSection() {
        return $this->hasMany(BedSection::class);
    }

    public function roomSection() {
        return $this->hasMany(RoomSection::class);
    }

    public function route() {
        return $this->belongsToMany(Route::class);
    }
}