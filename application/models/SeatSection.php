<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class SeatSection extends Eloquent{
    protected $table = 'accommodation_seat_section';

    public function rate() {
        return $this->hasMany(PublishRate::class, 'accommodation_type_category_id')
            ->where('accommodation_type_id', 1);
    }
}