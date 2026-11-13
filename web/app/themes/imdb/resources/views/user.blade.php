@extends ('layouts.app')

@section ('content')
  <h1>Welcome, {{ $currentUser->display_name }}</h1>
  <p>Email: {{ $currentUser->user_email }}</p>
  <p>Role: {{ implode(', ', $currentUser->roles) }}</p>

  <a href="{{ route('sign-off') }}">Uitloggen</a>
@endsection
