<?php

declare(strict_types=1);

/**
 * Theme filters.
 */

namespace App;

require_once __DIR__ . '/PostTypes/Movie.php';
require_once __DIR__ . '/PostTypes/Review.php';
require_once __DIR__ . '/PostTypes/Cast.php';

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
 * Cast archive: alphabetical, 24 people per page.
 *
 * @return void
 */
add_action('pre_get_posts', function ($query) {
    if (is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive('cast')) {
        return;
    }

    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', 24);
});
