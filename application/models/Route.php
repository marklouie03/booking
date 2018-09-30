<?php

use Illuminate\Database\Eloquent\Model as Eloquent;

class Route extends Eloquent{
    
    public function origin() {
        return $this->belongsTo(Port::class, 'from_port_id');
    }

    public function destination() {
        return $this->belongsTo(Port::class, 'to_port_id');
    }

    public function vessel() {
        return $this->belongsToMany(Vessel::class);
    }
}