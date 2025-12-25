<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'type',
        'value',
        'label',
        'section',
        'description'
    ];

    /**
     * Get content by key
     */
    public static function getContent($key, $default = '')
    {
        $content = self::where('key', $key)->first();
        return $content ? $content->value : $default;
    }

    /**
     * Set content by key
     */
    public static function setContent($key, $value)
    {
        return self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }

    /**
     * Get all content grouped by section
     */
    public static function getContentBySection()
    {
        return self::all()->groupBy('section');
    }
}
