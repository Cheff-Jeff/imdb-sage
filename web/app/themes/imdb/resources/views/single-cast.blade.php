@extends('layouts.app')

@section('content')
  @while (have_posts())
    {{-- the_post() lives in the block below: mixing the inline and block PHP directive breaks Blade --}}
    @php
      the_post();
      $films = $filmography();
      $professions = get_the_terms(get_the_ID(), 'post_tag') ?: [];
    @endphp

    <article @php(post_class('person'))>
      <header class="person-hero">
        <div class="person-hero__inner container-page">
          <figure class="person-hero__figure">
            <div class="person-hero__photo">
              @if (has_post_thumbnail())
                {!! get_the_post_thumbnail(null, 'large', ['alt' => sprintf(__('Foto van %s', 'sage'), get_the_title())]) !!}
              @else
                @include('partials.person-placeholder')
              @endif
            </div>

            {{-- Photo credit from the media library caption (required for CC BY / CC BY-SA photos) --}}
            @if (has_post_thumbnail() && ($photoCredit = wp_get_attachment_caption(get_post_thumbnail_id())))
              <figcaption class="person-hero__credit">{{ $photoCredit }}</figcaption>
            @endif
          </figure>

          <div class="person-hero__info">
            <a class="back-link" href="{{ get_post_type_archive_link('cast') }}">
              &larr; {{ __('Alle cast & crew', 'sage') }}
            </a>

            <h1 class="person-hero__name">{!! get_the_title() !!}</h1>

            @if ($professions)
              <ul class="person-hero__professions">
                @foreach ($professions as $profession)
                  <li>
                    <a
                      class="filter-chip"
                      href="{{ add_query_arg('tag', $profession->slug, get_post_type_archive_link('cast')) }}"
                    >
                      {{ $profession->name }}
                    </a>
                  </li>
                @endforeach
              </ul>
            @endif

            <p class="person-hero__meta">
              {{ sprintf(_n('Werkte mee aan %s film', 'Werkte mee aan %s films', $films->count(), 'sage'), number_format_i18n($films->count())) }}
            </p>

            @if (has_excerpt())
              <p class="person-hero__tagline">{{ get_the_excerpt() }}</p>
            @endif
          </div>
        </div>
      </header>

      <div class="container-page">
        @if (trim(get_the_content()) !== '')
          <section class="person-section">
            <h2 class="section-title">{{ __('Biografie', 'sage') }}</h2>
            <div class="prose-content">
              @php(the_content())
            </div>
          </section>
        @endif

        <section class="person-section" aria-labelledby="filmography-title">
          <h2 id="filmography-title" class="section-title">{{ __('Filmografie', 'sage') }}</h2>

          @if ($films->isNotEmpty())
            <ol class="filmography">
              @foreach ($films as $credit)
                <li class="filmography__item">
                  <a class="filmography__link" href="{{ get_permalink($credit['movie']) }}">
                    <figure class="filmography__poster">
                      @if (has_post_thumbnail($credit['movie']))
                        {!! get_the_post_thumbnail($credit['movie'], 'medium', ['alt' => '', 'loading' => 'lazy']) !!}
                      @else
                        @include('partials.poster-placeholder', ['title' => get_the_title($credit['movie'])])
                      @endif
                    </figure>

                    <div class="filmography__body">
                      <h3 class="filmography__title">{!! get_the_title($credit['movie']) !!}</h3>
                      @if ($credit['roles'])
                        <p class="filmography__role">
                          <span class="filmography__as">{{ __('als', 'sage') }}</span>
                          {{ implode(', ', $credit['roles']) }}
                        </p>
                      @endif
                    </div>

                    <span class="filmography__arrow" aria-hidden="true">&rarr;</span>
                  </a>
                </li>
              @endforeach
            </ol>
          @else
            <p class="cast-archive__empty">{{ __('Nog geen films gekoppeld.', 'sage') }}</p>
          @endif
        </section>
      </div>
    </article>
  @endwhile
@endsection
