<?php

declare(strict_types=1);

namespace App\View\Composers;

use Illuminate\Support\Collection;
use Roots\Acorn\View\Composer;

class Movie extends Composer
{
    public $reviews = [];

    public function __construct()
    {
        $this->reviews = $this->getReviews() ?? [];
    }

    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'single-movie',
    ];

    /**
     * Whether the logged in user has saved the current movie.
     */
    public function isSaved(): bool
    {
        $userId = get_current_user_id();

        if (! $userId) {
            return false;
        }

        $saved = get_field('user_saved_movies', "user_{$userId}", false) ?: [];

        return in_array(get_queried_object_id(), array_map('intval', (array) $saved), true);
    }

    public function getReviews(): Collection
    {
        return collect(get_posts([
            'post_type' => 'reviews',
            'meta_query' => [
                [
                    'key' => 'review_movie',
                    'value' => get_the_ID(),
                    'compare' => '=',
                ],
            ],
            'posts_per_page' => -1, // get_posts() returns only 5 by default
            'orderby' => 'date',
            'order' => 'DESC',
            'no_found_rows' => true,
        ]));
    }

    /**
     * Review count, average stars and how many reviews gave each star rating.
     *
     * @return array{count: int, average: float|null, breakdown: array<int, int>}
     */
    public function reviewStats(): array
    {
        $stars = collect($this->reviews)
            ->map(fn($review) => (int) get_field('reveiw_stars', $review->ID))
            ->filter(fn($rating) => $rating >= 1 && $rating <= 5);

        $breakdown = [];
        foreach (range(5, 1) as $rating) {
            $breakdown[$rating] = $stars->filter(fn($value) => $value === $rating)->count();
        }

        return [
            'count' => collect($this->reviews)->count(),
            'average' => $stars->isNotEmpty() ? round($stars->avg(), 1) : null,
            'breakdown' => $breakdown,
        ];
    }

    public function hasReviews(): bool
    {
        foreach ($this->reviews as $review) {
            $authorId = intval($review->post_author);

            if ($authorId === get_current_user_id()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Other movies to show below the current one.
     */
    public function relatedMovies(): Collection
    {
        return collect(get_posts([
            'post_type' => 'movie',
            'posts_per_page' => 6,
            'post__not_in' => [get_the_ID()],
            'orderby' => 'rand',
            'no_found_rows' => true,
        ]));
    }
}
