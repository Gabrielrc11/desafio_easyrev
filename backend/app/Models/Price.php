<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
