<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventimage extends Model
{


        protected $fillable = ['event_id', 'img', 'available'];


    use HasFactory;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
