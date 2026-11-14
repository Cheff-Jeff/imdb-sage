<?php

declare(strict_types=1);

add_action('init', function () {
    register_post_type('cast', [
        'labels' => [
            'name' => 'cast',
            'singular_name' => 'cast',
            'plural_name' => 'casting',
            'menu_name' => 'casting',
            'all_items' => 'full cast',
            'add_new' => 'Add new cast',
            'edit_item' => 'Edit cast',
            'view_item' => 'View cast',
            'search_items' => 'Search cast',
            'not_found' => 'No casting found',
            'not_found_in_trash' => 'No casting found in Trash',
        ],
        'menu_icon' => 'dashicons-groups',
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'casting'],
        'taxonomies' => ['post_tag'],
        'supports' => ['title', 'excerpt', 'editor', 'thumbnail'],
    ]);
});
