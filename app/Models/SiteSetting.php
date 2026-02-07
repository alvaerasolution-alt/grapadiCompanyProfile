<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];

    /**
     * Cache key prefix
     */
    private const CACHE_PREFIX = 'site_setting_';
    private const CACHE_TTL = 86400; // 24 hours

    /**
     * Get a setting value by key
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = self::CACHE_PREFIX . $key;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return self::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text'): void
    {
        // Encode JSON values
        if ($type === 'json' && is_array($value)) {
            $value = json_encode($value);
        }

        self::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $value,
                'type' => $type,
            ]
        );

        // Clear cache
        Cache::forget(self::CACHE_PREFIX . $key);
        Cache::forget(self::CACHE_PREFIX . 'group_' . $group);
    }

    /**
     * Get all settings for a group
     */
    public static function getGroup(string $group): array
    {
        $cacheKey = self::CACHE_PREFIX . 'group_' . $group;

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($group) {
            $settings = self::where('group', $group)->get();
            
            $result = [];
            foreach ($settings as $setting) {
                // Remove group prefix from key for easier access
                $shortKey = str_replace($group . '_', '', $setting->key);
                $result[$shortKey] = self::castValue($setting->value, $setting->type);
            }

            return $result;
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache(): void
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget(self::CACHE_PREFIX . $setting->key);
        }

        $groups = self::distinct()->pluck('group');
        foreach ($groups as $group) {
            Cache::forget(self::CACHE_PREFIX . 'group_' . $group);
        }
    }

    /**
     * Cast value based on type
     */
    private static function castValue(mixed $value, string $type): mixed
    {
        return match ($type) {
            'json' => is_string($value) ? json_decode($value, true) : $value,
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            default => $value,
        };
    }
}
