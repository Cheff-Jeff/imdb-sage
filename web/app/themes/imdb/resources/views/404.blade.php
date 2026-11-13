@extends('layouts.app')

@section('content')
  <div class="page-shell">
    @include('partials.page-header')

    @if (! have_posts())
      <x-alert type="warning">
        {{ __('Deze pagina bestaat niet (meer). Zoek een film of ga terug naar de homepage.', 'sage') }}
      </x-alert>

      {!! get_search_form(false) !!}
    @endif
  </div>
@endsection
