@extends('layouts.app')

@section('content')
  <section class="auth">
    <div class="auth__card">
      <p class="auth__eyebrow">{{ __('Doe mee', 'sage') }}</p>
      <h1 class="auth__title">{{ __('Registreren', 'sage') }}</h1>
      <p class="auth__intro">{{ __('Maak een account aan en hou bij welke films je gezien hebt.', 'sage') }}</p>

      @include('partials.form-errors')
      @include('forms.sign-up')

      <p class="auth__switch">
        {{ __('Heb je al een account?', 'sage') }}
        <a href="{{ route('sign-in') }}">{{ __('Log in', 'sage') }}</a>
      </p>
    </div>
  </section>
@endsection
