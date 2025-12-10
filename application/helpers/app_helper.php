<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('app_slug')) {
    /**
     * Returns the configured app slug (defaults to provincial for backward-compat).
     */
    function app_slug()
    {
        $slug = config_item('app_slug');
        return !empty($slug) ? $slug : 'provincial';
    }
}

if (!function_exists('app_name')) {
    /**
     * Returns the friendly app/meet name used across pages.
     */
    function app_name()
    {
        $name = config_item('app_name');
        return !empty($name) ? $name : 'Journalism Rankings';
    }
}

if (!function_exists('app_tagline')) {
    /**
     * Returns the app tagline for subtitles and meta descriptions.
     */
    function app_tagline()
    {
        $tagline = config_item('app_tagline');
        return !empty($tagline) ? $tagline : 'Live journalism standings and award tallies.';
    }
}

if (!function_exists('app_url')) {
    /**
     * Prepends the app slug to a path and returns a site_url() value.
     */
    function app_url($uri = '')
    {
        $slug = app_slug();
        $trimmed = ltrim((string) $uri, '/');
        $basePath = trim((string) parse_url(base_url(), PHP_URL_PATH), '/');
        $slugTrim = trim($slug, '/');
        $baseHasSlug = ($slugTrim !== '' && stripos($basePath, $slugTrim) !== false);

        // If base_url already contains the slug (e.g., app is in /journal), don't prepend again.
        if ($baseHasSlug) {
            return site_url($trimmed);
        }

        return site_url($slugTrim . ($trimmed !== '' ? '/' . $trimmed : ''));
    }
}

if (!function_exists('app_base_url')) {
    /**
     * Prepends the app slug to a path and returns a base_url() value.
     */
    function app_base_url($uri = '')
    {
        $slug = app_slug();
        $trimmed = ltrim((string) $uri, '/');
        $basePath = trim((string) parse_url(base_url(), PHP_URL_PATH), '/');
        $slugTrim = trim($slug, '/');
        $baseHasSlug = ($slugTrim !== '' && stripos($basePath, $slugTrim) !== false);

        if ($baseHasSlug) {
            return base_url($trimmed);
        }

        return base_url($slugTrim . ($trimmed !== '' ? '/' . $trimmed : ''));
    }
}
