<?php

namespace App\View\Composers;

use Illuminate\Support\Collection;
use Roots\Acorn\View\Composer;

class Movie extends Composer
{
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
