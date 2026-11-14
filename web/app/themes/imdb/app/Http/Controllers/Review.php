<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Review
{
    public function addReview(Request $request)
    {
        if (!$request->isMethod('post')) {
            abort(405);
        }

        $user = wp_get_current_user();
        if (!$user) {
            abort(401);
        }

        if (!$request->has('title') || !$request->has('content') || !$request->has('movie') || !$request->has('rating')) {
            abort(400);
        }

        $post_id = wp_insert_post([
            'post_type' => 'reviews',
            'post_title' => sanitize_text_field($request->input('title')),
            'post_content' => sanitize_textarea_field($request->input('content')),
            'post_status' => 'publish',
            'post_author' => $user->ID,
        ]);

        if (!$post_id) {
            abort(500);
        }

        update_field('review_movie', sanitize_text_field($request->input('movie')), $post_id);
        update_field('reveiw_stars', sanitize_text_field($request->input('rating')), $post_id);

        return back();
    }

    public function deleteReview(Request $request)
    {
        if (!$request->isMethod('post')) {
            abort(405);
        }

        $user = wp_get_current_user();
        if (!$user) {
            abort(401);
        }

        if (!$request->has('review')) {
            abort(400);
        }

        $review_id = intval($request->input('review'));
        $review = get_post($review_id);
        if (!$review || intval($review->post_author) !== $user->ID) {
            abort(403);
        }

        wp_delete_post($review_id, true);

        return back();
    }

    public function editReview(Request $request)
    {
        if (!$request->isMethod('post')) {
            abort(405);
        }

        $user = wp_get_current_user();
        if (!$user) {
            abort(401);
        }

        if (!$request->has('review') || !$request->has('title') || !$request->has('content') || !$request->has('rating')) {
            abort(400);
        }

        $review_id = intval($request->input('review'));
        $review = get_post($review_id);
        if (!$review || intval($review->post_author) !== $user->ID) {
            abort(403);
        }

        wp_update_post([
            'ID' => $review_id,
            'post_title' => sanitize_text_field($request->input('title')),
            'post_content' => sanitize_textarea_field($request->input('content')),
        ]);

        update_field('reveiw_stars', sanitize_text_field($request->input('rating')), $review_id);

        return back();
    }
}
