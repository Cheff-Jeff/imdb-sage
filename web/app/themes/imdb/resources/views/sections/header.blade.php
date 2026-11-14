@php($onMovies = is_post_type_archive('movie') || is_singular('movie'))
@php($onCast = is_post_type_archive('cast') || is_singular('cast'))

<header class="site-header">
  <div class="site-header__inner container-page">
    <a class="brand" href="{{ home_url('/') }}">
      <svg class="brand__icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
        <path d="M4 9h16v9.5A1.5 1.5 0 0 1 18.5 20h-13A1.5 1.5 0 0 1 4 18.5V9Z"/>
        <path d="m3.6 7.6-.4-1.5a1.5 1.5 0 0 1 1-1.8l11.7-3.2a1.5 1.5 0 0 1 1.9 1l.4 1.5L3.6 7.6Zm3.6-4.3 2.4 2.6 2.3-.6L9.6 2.6l-2.4.7Zm5.2-1.4 2.4 2.6 2.3-.6-2.4-2.6-2.3.6Z"/>
      </svg>
      <span class="brand__name">{{ $siteName }}</span>
    </a>

    <form class="site-search" role="search" method="get" action="{{ home_url('/') }}">
      <label for="site-search-input" class="sr-only">{{ __('Zoek films', 'sage') }}</label>
      <svg class="site-search__icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 1 0 0 11 5.5 5.5 0 0 0 0-11ZM2 9a7 7 0 1 1 12.45 4.39l3.08 3.08a.75.75 0 1 1-1.06 1.06l-3.08-3.08A7 7 0 0 1 2 9Z" clip-rule="evenodd"/>
      </svg>
      <input
        id="site-search-input"
        class="site-search__input"
        type="search"
        name="s"
        value="{{ get_search_query() }}"
        placeholder="{{ __('Zoek een film…', 'sage') }}"
      >
      <input type="hidden" name="post_type" value="movie">
    </form>

    <nav class="site-nav" aria-label="{{ __('Hoofdmenu', 'sage') }}">
      <a
        href="{{ get_post_type_archive_link('movie') }}"
        @class(['site-nav__link', 'site-nav__link--active' => $onMovies])
        @if ($onMovies) aria-current="page" @endif
      >
        {{ __('Films', 'sage') }}
      </a>

      <a
        href="{{ get_post_type_archive_link('cast') }}"
        @class(['site-nav__link', 'site-nav__link--active' => $onCast])
        @if ($onCast) aria-current="page" @endif
      >
        {{ __('Cast', 'sage') }}
      </a>

      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav', 'container' => false, 'depth' => 1, 'echo' => false]) !!}
      @endif

      @if (is_user_logged_in())
        <a class="account-chip" href="{{ route('account') }}">
          <img
            class="account-chip__avatar"
            src="{{ get_avatar_url(get_current_user_id(), ['size' => 64]) }}"
            alt=""
            width="32"
            height="32"
          >
          <span class="account-chip__name">{{ wp_get_current_user()->display_name }}</span>
        </a>
      @else
        <a class="button button--ghost" href="{{ route('sign-in') }}">{{ __('Inloggen', 'sage') }}</a>
        <a class="button button--primary" href="{{ route('sign-up') }}">{{ __('Registreren', 'sage') }}</a>
      @endif
    </nav>
  </div>
</header>
