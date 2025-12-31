<?php

use App\Models\SiteContent;

if (!function_exists('site_content')) {
    /**
     * Get site content by key
     *
     * @param string $key
     * @param string|null $default
     * @return string|null
     */
    function site_content($key, $default = null)
    {
        return SiteContent::getContent($key, $default);
    }
}

if (!function_exists('site_contents')) {
    /**
     * Get all site contents as key-value pairs
     *
     * @return array
     */
    function site_contents()
    {
        return SiteContent::getAllContent();
    }
}

if (!function_exists('site_content_by_section')) {
    /**
     * Get site contents by section
     *
     * @param string $section
     * @return \Illuminate\Database\Eloquent\Collection
     */
    function site_content_by_section($section)
    {
        return SiteContent::getBySection($section);
    }
}