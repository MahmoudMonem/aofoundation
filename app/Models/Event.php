<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'title_en',
        'title_ar',
        'short_desc_en',
        'short_desc_ar',
        'desc_en',
        'desc_ar',
        'cover',
        'logo',
        'thumbnail',
        'featured',
        'available',
        'slug',
    ];

    protected $casts = [
        'featured' => 'boolean',
        'available' => 'boolean',
    ];

    public function eventimages()
    {
        return $this->hasMany(Eventimage::class);
    }

    public function getFeaturedImage()
    {
        return $this->eventimages()->where('featured', 1)->first();
    }

    public function getNonFeaturedImages()
    {
        return $this->eventimages()->where('featured', '!=', 1)->get();
    }
}