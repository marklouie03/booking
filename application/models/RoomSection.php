<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class RoomSection extends Eloquent{
    protected $table = 'accommodation_room_section';

    public function rate() {
        return $this->hasMany(PublishRate::class, 'accommodation_type_category_id')
            ->where('accommodation_type_id', 3);
    }
}