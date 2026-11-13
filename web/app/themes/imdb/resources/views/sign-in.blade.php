@extends('layouts.app')

@section('content')
  <section class="auth">
    <div class="auth__card">
      <p class="auth__eyebrow">{{ __('Welkom terug', 'sage') }}</p>
      <h1 class="auth__title">{{ __('Inloggen', 'sage') }}</h1>
      <p class="auth__intro">{{ __('Log in om verder te gaan waar je gebleven was.', 'sage') }}</p>

      @include('partials.form-errors')
      @include('forms.sign-in')

      <p class="auth__switch">
        {{ __('Nog geen account?', 'sage') }}
        <a href="{{ route('sign-up') }}">{{ __('Registreer je gratis', 'sage') }}</a>
      </p>
    </div>
  </section>
@endsection
