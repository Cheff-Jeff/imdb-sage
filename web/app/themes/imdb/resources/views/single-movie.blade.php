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

            <div class="movie-hero__actions">
              @if (is_user_logged_in())
                {{-- Composer methods are invokable objects: call it, or it is always truthy. --}}
                @php($saved = $isSaved())

                <form action="{{ route('saveMovie') }}" method="post">
                  <input type="hidden" name="movieId" value="{{ get_the_ID() }}" />

                  <button
                    type="submit"
                    @class(['save-toggle', 'save-toggle--saved' => $saved])
                    aria-pressed="{{ $saved ? 'true' : 'false' }}"
                  >
                    @include('partials.icon-bookmark', ['filled' => $saved])
                    <span>{{ $saved ? __('Opgeslagen', 'sage') : __('Opslaan', 'sage') }}</span>
                  </button>
                </form>
              @else
                <a class="save-toggle" href="{{ route('sign-in') }}">
                  @include('partials.icon-bookmark', ['filled' => false])
                  <span>{{ __('Log in om op te slaan', 'sage') }}</span>
                </a>
              @endif
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
