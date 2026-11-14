@extends('layouts.app')

@section('content')
  @php
    $professions = $professions();
    $active = $activeProfession();
    $archiveUrl = get_post_type_archive_link('cast');
    $total = (int) $GLOBALS['wp_query']->found_posts;
  @endphp

  <section class="cast-archive container-page">
    <header class="cast-archive__header">
      <div>
        <h1 class="cast-archive__title">{{ __('Cast & crew', 'sage') }}</h1>
        @if (have_posts())
          <p class="cast-archive__count">
            {{ sprintf(_n('%s persoon', '%s personen', $total, 'sage'), number_format_i18n($total)) }}
          </p>
        @endif
      </div>

      @if ($professions)
        <nav class="filter-chips" aria-label="{{ __('Filter op beroep', 'sage') }}">
          <a
            href="{{ $archiveUrl }}"
            @class(['filter-chip', 'filter-chip--active' => $active === ''])
            @if ($active === '') aria-current="page" @endif
          >
            {{ __('Iedereen', 'sage') }}
          </a>

          @foreach ($professions as $profession)
            <a
              href="{{ add_query_arg('tag', $profession->slug, $archiveUrl) }}"
              @class(['filter-chip', 'filter-chip--active' => $active === $profession->slug])
              @if ($active === $profession->slug) aria-current="page" @endif
            >
              {{ $profession->name }}
            </a>
          @endforeach
        </nav>
      @endif
    </header>

    @if (have_posts())
      <div class="person-grid">
        @while (have_posts()) @php(the_post())
          @include('partials.content-cast')
        @endwhile
      </div>

      {!! get_the_posts_pagination([
        'mid_size' => 1,
        'prev_text' => '&larr; <span class="sr-only">' . __('Vorige', 'sage') . '</span>',
        'next_text' => '<span class="sr-only">' . __('Volgende', 'sage') . '</span> &rarr;',
      ]) !!}
    @else
      <p class="cast-archive__empty">
        {{ __('Geen personen gevonden.', 'sage') }}
      </p>
    @endif
  </section>
@endsection
