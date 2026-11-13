@extends('layouts.app')

@php
  $roleNames = collect($currentUser->roles)
    ->map(fn ($role) => translate_user_role(wp_roles()->roles[$role]['name'] ?? $role))
    ->implode(', ');
@endphp

@section('content')
  <section class="account">
    <header class="account__header">
      <img
        class="account__avatar"
        src="{{ get_avatar_url($currentUser->ID, ['size' => 224]) }}"
        alt=""
        width="112"
        height="112"
      >

      <div>
        <p class="account__eyebrow">{{ __('Mijn account', 'sage') }}</p>
        <h1 class="account__name">{{ $currentUser->display_name }}</h1>
        <p class="account__email">{{ $currentUser->user_email }}</p>
      </div>
    </header>

    <div class="account__card">
      <h2 class="section-title">{{ __('Gegevens', 'sage') }}</h2>

      <dl class="account__details">
        <div class="account__row">
          <dt>{{ __('Naam', 'sage') }}</dt>
          <dd>{{ $currentUser->display_name }}</dd>
        </div>
        <div class="account__row">
          <dt>{{ __('E-mailadres', 'sage') }}</dt>
          <dd>{{ $currentUser->user_email }}</dd>
        </div>
        <div class="account__row">
          <dt>{{ __('Rol', 'sage') }}</dt>
          <dd><span class="account__badge">{{ $roleNames }}</span></dd>
        </div>
        <div class="account__row">
          <dt>{{ __('Lid sinds', 'sage') }}</dt>
          <dd>{{ date_i18n(get_option('date_format'), strtotime($currentUser->user_registered)) }}</dd>
        </div>
      </dl>
    </div>

    <div class="account__actions">
      <a class="button button--primary" href="{{ get_post_type_archive_link('movie') }}">
        {{ __('Films ontdekken', 'sage') }}
      </a>
      <a class="button button--outline" href="{{ route('sign-off') }}">
        {{ __('Uitloggen', 'sage') }}
      </a>
    </div>
  </section>
@endsection
