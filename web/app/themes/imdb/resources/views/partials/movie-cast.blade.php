{{-- Cast & crew of a movie. Expects $credits: Collection of ['person' => WP_Post, 'roles' => string[]]. --}}
@if ($credits->isNotEmpty())
  <section class="movie-cast" aria-labelledby="cast-title">
    <div class="movie-cast__header">
      <h2 id="cast-title" class="section-title">{{ __('Cast & crew', 'sage') }}</h2>
      <a class="movie-cast__all" href="{{ get_post_type_archive_link('cast') }}">
        {{ __('Alle cast & crew', 'sage') }} &rarr;
      </a>
    </div>

    <ul class="cast-list">
      @foreach ($credits as $credit)
        <li>
          <a class="cast-credit" href="{{ get_permalink($credit['person']) }}">
            <span class="cast-credit__photo">
              @if (has_post_thumbnail($credit['person']))
                {!! get_the_post_thumbnail($credit['person'], 'thumbnail', ['alt' => '', 'loading' => 'lazy']) !!}
              @else
                @include('partials.person-placeholder')
              @endif
            </span>

            <span class="cast-credit__body">
              <span class="cast-credit__name">{!! get_the_title($credit['person']) !!}</span>
              @if ($credit['roles'])
                <span class="cast-credit__role">{{ implode(', ', $credit['roles']) }}</span>
              @endif
            </span>
          </a>
        </li>
      @endforeach
    </ul>
  </section>
@endif
