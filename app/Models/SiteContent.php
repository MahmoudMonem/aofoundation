<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteContent extends Model
{
    use HasFactory;

    protected $table = 'site_contents';

    protected $fillable = [
        'key',
        'type',
        'value',
        'label',
        'section',
        'description',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Get content grouped by section
     */
    public static function getContentBySection()
    {
        return self::where('is_active', true)
            ->orderBy('section')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section');
    }

    /**
     * Get a single content value by key
     */
    public static function getContent($key, $default = null)
    {
        $cacheKey = 'site_content_' . $key;
        
        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $content = self::where('key', $key)->where('is_active', true)->first();
            return $content ? $content->value : $default;
        });
    }

    /**
     * Set content value by key
     */
    public static function setContent($key, $value)
    {
        $content = self::where('key', $key)->first();
        
        if ($content) {
            $content->update(['value' => $value]);
            
            // Clear cache for this key
            Cache::forget('site_content_' . $key);
            Cache::forget('site_contents_all');
            
            return $content;
        }
        
        return null;
    }

    /**
     * Get all content as key-value pairs
     */
    public static function getAllContent()
    {
        return Cache::remember('site_contents_all', 3600, function () {
            return self::where('is_active', true)
                ->pluck('value', 'key')
                ->toArray();
        });
    }

    /**
     * Get content by section
     */
    public static function getBySection($section)
    {
        return self::where('section', $section)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Clear all content cache
     */
    public static function clearCache()
    {
        $keys = self::pluck('key');
        
        foreach ($keys as $key) {
            Cache::forget('site_content_' . $key);
        }
        
        Cache::forget('site_contents_all');
    }

    /**
     * Boot method to clear cache on model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget('site_content_' . $model->key);
            Cache::forget('site_contents_all');
        });

        static::deleted(function ($model) {
            Cache::forget('site_content_' . $model->key);
            Cache::forget('site_contents_all');
        });
    }
}