@extends('layouts.app')

@php
  $roleNames = collect($currentUser->roles)
    ->map(fn ($role) => translate_user_role(wp_roles()->roles[$role]['name'] ?? $role))
    ->implode(', ');

  // $savedMovies holds raw IDs from ACF: turn them into published movie posts.
  $movies = collect($savedMovies ?: [])
    ->map(fn ($id) => get_post((int) $id))
    ->filter(fn ($post) => $post && $post->post_type === 'movie' && $post->post_status === 'publish')
    ->values();
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

    <section class="account__saved" aria-labelledby="saved-movies-title">
      <div class="account__saved-header">
        <h2 id="saved-movies-title" class="section-title">{{ __('Mijn films', 'sage') }}</h2>
        @if ($movies->isNotEmpty())
          <p class="account__saved-count">
            {{ sprintf(_n('%s opgeslagen', '%s opgeslagen', $movies->count(), 'sage'), number_format_i18n($movies->count())) }}
          </p>
        @endif
      </div>

      @if ($movies->isNotEmpty())
        <div class="account__movies">
          @foreach ($movies as $movie)
            <div class="saved-movie">
              @include('partials.content-movie', ['movie' => $movie])

              <form class="saved-movie__remove" action="{{ route('saveMovie') }}" method="post">
                <input type="hidden" name="movieId" value="{{ $movie->ID }}" />
                <button type="submit" class="saved-movie__remove-button">
                  {{ __('Verwijderen', 'sage') }}
                  <span class="sr-only">{{ sprintf(__('%s uit mijn films', 'sage'), get_the_title($movie)) }}</span>
                </button>
              </form>
            </div>
          @endforeach
        </div>
      @else
        <div class="account__empty">
          @include('partials.icon-bookmark', ['filled' => false])
          <p>{{ __('Je hebt nog geen films opgeslagen. Klik op "Opslaan" bij een film om hem hier te bewaren.', 'sage') }}</p>
          <a class="button button--primary" href="{{ get_post_type_archive_link('movie') }}">
            {{ __('Films ontdekken', 'sage') }}
          </a>
        </div>
      @endif
    </section>

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
