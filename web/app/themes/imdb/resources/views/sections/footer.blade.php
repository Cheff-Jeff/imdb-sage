<footer class="site-footer">
  <div class="site-footer__inner container-page">
    <div>
      <a class="brand" href="{{ home_url('/') }}">
        <span class="brand__name">{{ $siteName }}</span>
      </a>
      <p class="site-footer__tagline">{{ __('Alles over films. Gebouwd voor de lol.', 'sage') }}</p>
    </div>

    <ul class="site-footer__links">
      <li><a href="{{ get_post_type_archive_link('movie') }}">{{ __('Alle films', 'sage') }}</a></li>
      <li><a href="{{ get_post_type_archive_link('cast') }}">{{ __('Cast & crew', 'sage') }}</a></li>
      @if (is_user_logged_in())
        <li><a href="{{ route('account') }}">{{ __('Mijn account', 'sage') }}</a></li>
      @else
        <li><a href="{{ route('sign-in') }}">{{ __('Inloggen', 'sage') }}</a></li>
        <li><a href="{{ route('sign-up') }}">{{ __('Registreren', 'sage') }}</a></li>
      @endif
    </ul>

    <p class="site-footer__copy">&copy; {{ date('Y') }} {{ $siteName }}</p>
  </div>
</footer>
