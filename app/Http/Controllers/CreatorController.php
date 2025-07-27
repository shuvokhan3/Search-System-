<?php

namespace App\Http\Controllers;

use App\Models\Creator;
use Illuminate\Http\Request;

class CreatorController extends Controller
{
    /**
     * Search creators with filters and pagination
     */

    public function search(Request $request){
        $perPage = $request->get('per_page', 10);// Default 10 results per page
        $page = $request->get('page', 1);

        $query = Creator::query()->active();

        //apply filters
        $this->applyFilters($query, $request);

        //paginatie result
        $creators = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $creators->items(),
            'pagination' => [
                'current_page' => $creators->currentPage(),
                'last_page' => $creators->lastPage(),
                'per_page' => $creators->perPage(),
                'total' => $creators->total(),
                'from' => $creators->firstItem(),
                'to' => $creators->lastItem(),
                'has_more_pages' => $creators->hasMorePages(),
                'links' => [
                    'first' => $creators->url(1),
                    'last' => $creators->url($creators->lastPage()),
                    'prev' => $creators->previousPageUrl(),
                    'next' => $creators->nextPageUrl(),
                ]
            ],

            'filters_applied' => $this->getAppliedFilters($request)
        ]);



    }

    /**
     * Get trending creators
     */
    public function trending(Request $request){
        $perPage = $request->get('per_page',10);

        $query = Creator::query()->active()->trending();

        // Still apply platform and category filters if provided
        $query->platform($request->get('platform'))
            ->category($request->get('category'));

        $creators = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $creators->items(),
            'pagination' => [
                'current_page' => $creators->currentPage(),
                'last_page' => $creators->lastPage(),
                'per_page' => $creators->perPage(),
                'total' => $creators->total(),
                'from' => $creators->firstItem(),
                'to' => $creators->lastItem(),
                'has_more_pages' => $creators->hasMorePages(),
            ],
            'filter_type' => 'trending'
        ]);

    }

    /**
     * Get rising stars
     */

    public function risingStars(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = Creator::query()->active()->risingStars();

        $query->platform($request->get('platform'))
            ->category($request->get('category'));

        $creators = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $creators->items(),
            'pagination' => [
                'current_page' => $creators->currentPage(),
                'last_page' => $creators->lastPage(),
                'per_page' => $creators->perPage(),
                'total' => $creators->total(),
                'has_more_pages' => $creators->hasMorePages(),
            ],
            'filter_type' => 'rising_stars'
        ]);
    }

    /**
     * Get most viewed creators
     */
    public function mostViewed(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = Creator::query()->active()->mostViewed();

        $query->platform($request->get('platform'))
            ->category($request->get('category'));

        $creators = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $creators->items(),
            'pagination' => [
                'current_page' => $creators->currentPage(),
                'last_page' => $creators->lastPage(),
                'per_page' => $creators->perPage(),
                'total' => $creators->total(),
                'has_more_pages' => $creators->hasMorePages(),
            ],
            'filter_type' => 'most_viewed'
        ]);
    }

    /**
     * Get creators under specific price
     */
    public function underPrice(Request $request)
    {
        $maxPrice = $request->get('max_price', 250);
        $perPage = $request->get('per_page', 10);

        $query = Creator::query()->active()->underPrice($maxPrice);

        $query->platform($request->get('platform'))
            ->category($request->get('category'));

        $creators = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $creators->items(),
            'pagination' => [
                'current_page' => $creators->currentPage(),
                'last_page' => $creators->lastPage(),
                'per_page' => $creators->perPage(),
                'total' => $creators->total(),
                'has_more_pages' => $creators->hasMorePages(),
            ],
            'filter_type' => 'under_price',
            'max_price' => $maxPrice
        ]);
    }

    /**
     * Get fast turnaround creators
     */
    public function fastTurnaround(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = Creator::query()->active()->fastTurnaround();

        $query->platform($request->get('platform'))
            ->category($request->get('category'));

        $creators = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $creators->items(),
            'pagination' => [
                'current_page' => $creators->currentPage(),
                'last_page' => $creators->lastPage(),
                'per_page' => $creators->perPage(),
                'total' => $creators->total(),
                'has_more_pages' => $creators->hasMorePages(),
            ],
            'filter_type' => 'fast_turnaround'
        ]);
    }

    /**
     * Get top creators
     */
    public function topCreators(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $query = Creator::query()->active()->topCreators();

        $query->platform($request->get('platform'))
            ->category($request->get('category'));

        $creators = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $creators->items(),
            'pagination' => [
                'current_page' => $creators->currentPage(),
                'last_page' => $creators->lastPage(),
                'per_page' => $creators->perPage(),
                'total' => $creators->total(),
                'has_more_pages' => $creators->hasMorePages(),
            ],
            'filter_type' => 'top_creators'
        ]);
    }

    /**
     * Get available filter options
     */
    public function getFilterOptions()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'platforms' => Creator::getAvailablePlatforms(),
                'categories' => Creator::getAvailableCategories(),
                'filter_types' => [
                    'rising_stars',
                    'most_viewed',
                    'trending',
                    'under_price',
                    'fast_turnaround',
                    'top_creators'
                ]
            ]
        ]);
    }

    /**
     * Apply filter to the query
    */
    private function applyFilters($query, Request $request)
    {
        //Platform filter
        if($request->has('platform') && $request->platform){
            $query->platform($request->platform);
        }

        // Category filter
        if ($request->has('category') && $request->category) {
            $query->category($request->category);
        }

        // Search term
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // Price range filter
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price_per_post', '<=', $request->max_price);
        }


        if ($request->has('min_price') && $request->min_price) {
            $query->where('price_per_post', '>=', $request->min_price);
        }

        // Followers count filter
        if ($request->has('min_followers') && $request->min_followers) {
            $query->where('followers_count', '>=', $request->min_followers);
        }



    }
    /**
     * Apply sorting to the query
     */

    private function applySorting($query, Request $request){
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDirection = $request->get('sort_direction', 'desc');

        $allowedSortFields = [
            'name', 'followers_count', 'engagement_rate',
            'price_per_post','view_count','created_at'
        ];

        if(in_array($sortBy,$allowedSortFields)){
            $query->orderBy($sortBy, $sortDirection);
        }else{
            $query->orderBy('created_at', 'desc');
        }
    }
    private function getAppliedFilters(Request $request)
    {
        return [
            'platform' => $request->get('platform'),
            'category' => $request->get('category'),
            'search' => $request->get('search'),
            'max_price' => $request->get('max_price'),
            'min_price' => $request->get('min_price'),
            'min_followers' => $request->get('min_followers'),
            'sort_by' => $request->get('sort_by', 'created_at'),
            'sort_direction' => $request->get('sort_direction', 'desc'),
        ];
    }


}
