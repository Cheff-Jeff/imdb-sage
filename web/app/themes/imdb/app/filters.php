<?php

declare(strict_types=1);

/**
 * Theme filters.
 */

namespace App;

function handleSignUp()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST)) {
        return;
    }

    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $password = sanitize_text_field($_POST['password'] ?? '');

    if (empty($name) || empty($email) || empty($password)) {
        return;
    }

    $user_id = wp_create_user($email, $password, $email);
    if (is_wp_error($user_id)) {
        return;
    }

    wp_update_user([
        'ID' => $user_id,
        'display_name' => $name,
    ]);

    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
}

add_action('init', __NAMESPACE__ . '\\handleSignUp');
