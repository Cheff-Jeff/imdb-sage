<?php

declare(strict_types=1);

register_post_type('movie', [
    'labels' => [
        'name' => 'Movie',
        'singular_name' => 'Movie',
        'plural_name' => 'Movies',
        'menu_name' => 'Movies',
        'all_items' => 'All Movies',
        'add_new' => 'Add New Movie',
        'edit_item' => 'Edit Movie',
        'view_item' => 'View Movie',
        'search_items' => 'Search Movies',
        'not_found' => 'No Movies found',
        'not_found_in_trash' => 'No Movies found in Trash',
    ],
    'menu_icon' => 'dashicons-video-alt2',
    'public' => true,
    'has_archive' => true,
    'show_in_rest' => true,
    'rewrite' => ['slug' => 'movies'],
    'supports' => ['title', 'excerpt', 'editor', 'thumbnail'],
]);
