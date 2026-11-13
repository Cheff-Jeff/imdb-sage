@extends('layouts.app')

@section('content')
  <section class="movies-archive container-page">
    <header class="movies-archive__header">
      <h1 class="movies-archive__title">{{ __('Films', 'sage') }}</h1>

      @if (have_posts())
        @php($total = (int) $GLOBALS['wp_query']->found_posts)
        <p class="movies-archive__count">
          {{ sprintf(_n('%s film', '%s films', $total, 'sage'), number_format_i18n($total)) }}
        </p>
      @endif
    </header>

    @if (have_posts())
      <div class="movie-grid">
        @while (have_posts()) @php(the_post())
          @include('partials.content-movie')
        @endwhile
      </div>

      {!! get_the_posts_pagination([
        'mid_size' => 1,
        'prev_text' => '&larr; <span class="sr-only">' . __('Vorige', 'sage') . '</span>',
        'next_text' => '<span class="sr-only">' . __('Volgende', 'sage') . '</span> &rarr;',
      ]) !!}
    @else
      <p class="movies-archive__empty">
        {{ __('Er staan nog geen films in de database. Voeg er een toe via het dashboard.', 'sage') }}
      </p>
    @endif
  </section>
@endsection
