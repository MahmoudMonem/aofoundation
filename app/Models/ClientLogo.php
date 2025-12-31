<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientLogo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'logo',
        'row',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'row' => 'integer',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get logos for row 1
     */
    public static function getRow1()
    {
        return self::where('is_active', true)
            ->where('row', 1)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get logos for row 2
     */
    public static function getRow2()
    {
        return self::where('is_active', true)
            ->where('row', 2)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Get all logos grouped by row
     */
    public static function getLogosByRow()
    {
        return self::where('is_active', true)
            ->orderBy('row')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('row');
    }

    /**
     * Get logo URL
     */
    public function getLogoUrlAttribute()
    {
        if (str_starts_with($this->logo, 'http')) {
            return $this->logo;
        }
        return asset($this->logo);
    }
}