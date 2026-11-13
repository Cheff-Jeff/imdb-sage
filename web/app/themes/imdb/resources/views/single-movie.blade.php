@extends ('layouts.app')

@section ('content')
  @while (have_posts())
    @php (the_post())
    <article @php (post_class('movie'))>
      <header class="movie-hero">
        @if (has_post_thumbnail())
          {!! get_the_post_thumbnail(null, 'large', ['class' => 'movie-hero__backdrop', 'alt' => '', 'aria-hidden' => 'true']) !!}
        @endif

        <div class="movie-hero__inner container-page">
          <figure class="movie-hero__poster">
            @if (has_post_thumbnail())
              {!! get_the_post_thumbnail(null, 'large', ['alt' => sprintf(__('Poster van %s', 'sage'), get_the_title())]) !!}
            @else
              @include ('partials.poster-placeholder', ['title' => get_the_title()])
            @endif
          </figure>

          <div class="movie-hero__info">
            <a class="back-link" href="{{ get_post_type_archive_link('movie') }}">
              &larr; {{ __('Alle films', 'sage') }}
            </a>

            <h1 class="movie-hero__title">{!! get_the_title() !!}</h1>

            <p class="movie-hero__meta">
              <span>{{ __('Film', 'sage') }}</span>
              <span class="movie-hero__dot" aria-hidden="true">&bull;</span>
              <span>
                {{ __('Toegevoegd op', 'sage') }}
                <time datetime="{{ get_post_time('c', true) }}">{{ get_the_date() }}</time>
              </span>
            </p>

            @if (has_excerpt())
              <p class="movie-hero__tagline">{{ get_the_excerpt() }}</p>
            @endif
          </div>

          <div class="action">
            <div class="save">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                <path d="M160 96C124.7 96 96 124.7 96 160L96 480C96 515.3 124.7 544 160 544L480 544C515.3 544 544 515.3 544 480L544 237.3C544 220.3 537.3 204 525.3 192L448 114.7C436 102.7 419.7 96 402.7 96L160 96zM192 192C192 174.3 206.3 160 224 160L384 160C401.7 160 416 174.3 416 192L416 256C416 273.7 401.7 288 384 288L224 288C206.3 288 192 273.7 192 256L192 192zM320 352C355.3 352 384 380.7 384 416C384 451.3 355.3 480 320 480C284.7 480 256 451.3 256 416C256 380.7 284.7 352 320 352z" />
              </svg>
            </div>
          </div>
        </div>
      </header>

      <div class="container-page">
        @if (trim(get_the_content()) !== '')
          <section class="movie-body">
            <h2 class="section-title">{{ __('Verhaal', 'sage') }}</h2>
            <div class="prose-content">
              @php (the_content())
            </div>
          </section>
        @endif

        @if ($relatedMovies->isNotEmpty())
          <section class="movie-related">
            <h2 class="section-title">{{ __('Meer films', 'sage') }}</h2>
            <div class="movie-grid">
              @foreach ($relatedMovies as $movie)
                @include ('partials.content-movie', ['movie' => $movie])
              @endforeach
            </div>
          </section>
        @endif
      </div>
    </article>
  @endwhile
@endsection
