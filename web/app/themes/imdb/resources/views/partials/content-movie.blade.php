{{-- Movie card. Pass a WP_Post as $movie, or leave it out to use the current post in the loop. --}}
@php($movie = $movie ?? get_post())

<article @php(post_class('movie-card', $movie))>
  <a class="movie-card__link" href="{{ get_permalink($movie) }}">
    <figure class="movie-card__poster">
      @if (has_post_thumbnail($movie))
        {!! get_the_post_thumbnail($movie, 'medium_large', ['class' => 'movie-card__image', 'alt' => '', 'loading' => 'lazy']) !!}
      @else
        @include('partials.poster-placeholder', ['title' => get_the_title($movie)])
      @endif
    </figure>

    <div class="movie-card__body">
      <h3 class="movie-card__title">{!! get_the_title($movie) !!}</h3>

      @if (has_excerpt($movie))
        <p class="movie-card__excerpt">{{ get_the_excerpt($movie) }}</p>
      @endif
    </div>
  </a>
</article>
