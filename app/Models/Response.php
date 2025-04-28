<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'phone', 'message'];

         // Table Name 
         protected $table = 'responses';
         // Primary Key 
         public $primaryKey = 'id';
         // Update Created and updated at automatically
         public $timestamps = true;
     
     
     

    
}
