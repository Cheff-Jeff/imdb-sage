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
