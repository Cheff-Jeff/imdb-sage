@extends('layouts.app')

@section('content')
  <div class="page-shell">
    @include('partials.page-header')

    @if (! have_posts())
      <x-alert type="caution">
        {{ __('Geen films gevonden. Probeer een andere zoekterm.', 'sage') }}
      </x-alert>

      {!! get_search_form(false) !!}
    @else
      <div class="movie-grid">
        @while(have_posts()) @php(the_post())
          @includeFirst(['partials.content-' . get_post_type(), 'partials.content-search'])
        @endwhile
      </div>

      {!! get_the_posts_pagination(['mid_size' => 1]) !!}
    @endif
  </div>
@endsection
