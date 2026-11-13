<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class User
{
    public function signUp(Request $request)
    {
        if (!$request->isMethod('post')) {
            return redirect()->route('sign-up');
        }

        if (!$request->has(['name', 'email', 'password'])) {
            return redirect()->route('sign-up');
        }

        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $userId = wp_create_user($name, $password, $email);
        if (is_wp_error($userId)) {
            return redirect()->route('sign-up');
        }

        wp_update_user([
            'ID' => $userId,
            'display_name' => $name,
            'role' => 'subscriber',
        ]);

        wp_set_current_user($userId);
        wp_set_auth_cookie($userId);

        return redirect()->route('account');
    }

    public function signIn(Request $request)
    {
        if (!$request->isMethod('post')) {
            return redirect()->route('sign-in');
        }

        if (!$request->has(['email', 'password'])) {
            return redirect()->route('sign-in');
        }

        $email = $request->input('email');
        $password = $request->input('password');

        $user = wp_authenticate($email, $password);
        if (is_wp_error($user)) {
            return redirect()->route('sign-in');
        }

        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);

        return redirect()->route('account');
    }

    public function signOff()
    {
        wp_logout();
        return redirect()->route('sign-up');
    }

    public function accountView()
    {
        if (!is_user_logged_in()) {
            return redirect()->route('sign-up');
        }

        $currentUser = wp_get_current_user();
        $userId = get_current_user_id();
        $savedMovies = get_field('user_saved_movies', "user_{$userId}", false);

        return view('user', ['currentUser' => $currentUser, 'savedMovies' => $savedMovies]);
    }

    public function saveMovie(Request $request)
    {
        if (!$request->isMethod('post')) {
            return back();
        }

        if (!$request->has(['movieId'])) {
            return back();
        }

        $userId = get_current_user_id();

        if (!$userId) {
            return back();
        }

        $post = intval($request->input('movieId'));
        $field = get_field('user_saved_movies', "user_{$userId}", false) ?: [];

        if (!in_array($post, array_map('intval', $field), true)) {
            $field[] = $post;
            update_field('user_saved_movies', array_map('intval', $field), "user_{$userId}");
        } else {
            $fields = array_values(array_filter(
                array_map('intval', $field),
                fn($id) => $id !== $post,
            ));

            update_field('user_saved_movies', $fields, "user_{$userId}");
        }

        return back();
    }

    public function signInView()
    {
        return view('sign-in');
    }

    public function signUpView()
    {
        return view('sign-up');
    }
}
