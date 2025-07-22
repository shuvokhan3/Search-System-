<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'email',
        'platform',
        'category',
        'bio',
        'profile_image',
        'followers_count',
        'engagement_rate',
        'price_per_post',
        'is_trending',
        'is_rising_star',
        'is_top_creator',
        'views_count',
        'fast_turnaround',
        'is_active'
    ];

    protected $casts = [
        'is_trending' => 'boolean',
        'is_rising_star' => 'boolean',
        'is_top_creator' => 'boolean',
        'fast_turnaround' => 'boolean',
        'is_active' => 'boolean',
        'price_per_post' => 'decimal:2',
    ];

    //Scope for active creator

    public function scopeActive($query)
    {
        return $query->where('is_active',true);
    }

    //scope for platform filter
    public function scopePlatform($query, $platform)
    {
        if($platform){
            return $query->where('platform',$platform);
        }
        return $query;
    }

    // Scope for category filter
    public function scopeCategory($query, $category){
        if ($category) {
            return $query->where('category', $category);
        }
        return $query;
    }

    // Scope for trending
    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    // Scope for rising stars
    public function scopeRisingStars($query)
    {
        return $query->where('is_rising_star', true);
    }

    // Scope for most viewed
    public function scopeMostViewed($query)
    {
        return $query->orderBy('views_count', 'desc');
    }

    // Scope for under price
    public function scopeUnderPrice($query, $maxPrice = 250)
    {
        return $query->where('price_per_post', '<=', $maxPrice);
    }

    // Scope for fast turnaround
    public function scopeFastTurnaround($query)
    {
        return $query->where('fast_turnaround', true);
    }

    // Scope for top creators
    public function scopeTopCreators($query)
    {
        return $query->where('is_top_creator', true);
    }


    // Search scope
    public function scopeSearch($query, $searchTerm)
    {
        if ($searchTerm) {
            return $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('username', 'like', '%' . $searchTerm . '%')
                    ->orWhere('bio', 'like', '%' . $searchTerm . '%');
            });
        }
        return $query;
    }

    // Get available platforms
    public static function getAvailablePlatforms()
    {
        return self::distinct()->pluck('platform')->toArray();
    }

    // Get available categories
    public static function getAvailableCategories()
    {
        return self::distinct()->pluck('category')->toArray();
    }







}
