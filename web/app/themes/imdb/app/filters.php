<?php

declare(strict_types=1);

/**
 * Theme filters.
 */

namespace App;

require_once __DIR__ . '/PostTypes/Movie.php';
require_once __DIR__ . '/PostTypes/Review.php';

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});
