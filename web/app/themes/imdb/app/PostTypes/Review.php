<?php

declare(strict_types=1);

register_post_type('reviews', [
    'labels' => [
        'name' => 'Reviews',
        'singular_name' => 'Review',
        'plural_name' => 'Reviews',
        'menu_name' => 'Reviews',
        'all_items' => 'All reviews',
        'add_new' => 'Add New review',
        'edit_item' => 'Edit review',
        'view_item' => 'View review',
        'search_items' => 'Search reviews',
        'not_found' => 'No reviews found',
        'not_found_in_trash' => 'No reviews found in Trash',
    ],
    'menu_icon' => 'dashicons-star-filled',
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'has_archive' => false,
    'show_in_rest' => true,
    'rewrite' => ['slug' => 'reviews'],
    'supports' => ['title', 'editor'],
]);
