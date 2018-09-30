<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class BedSection extends Eloquent{
    protected $table = 'accommodation_bed_section';

    public function rate() {
        return $this->hasMany(PublishRate::class, 'accommodation_type_category_id')
            ->where('accommodation_type_id', 2);
    }
}