@if (isset($errors) && $errors->any())
  <x-alert type="warning" class="auth__alert">
    @if ($errors->count() === 1)
      {{ $errors->first() }}
    @else
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    @endif
  </x-alert>
@endif
