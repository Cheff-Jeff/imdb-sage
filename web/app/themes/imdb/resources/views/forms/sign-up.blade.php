<form class="form" action="{{ route('sign-up.post') }}" method="post">
  <div class="form__field">
    <label class="form__label" for="name">{{ __('Naam', 'sage') }}</label>
    <input
      class="form__input"
      type="text"
      id="name"
      name="name"
      value="{{ old('name') }}"
      autocomplete="name"
      required
      @if (isset($errors) && $errors->has('name')) aria-invalid="true" @endif
    />
  </div>

  <div class="form__field">
    <label class="form__label" for="email">{{ __('E-mailadres', 'sage') }}</label>
    <input
      class="form__input"
      type="email"
      id="email"
      name="email"
      value="{{ old('email') }}"
      autocomplete="email"
      placeholder="jij@voorbeeld.nl"
      required
      @if (isset($errors) && $errors->has('email')) aria-invalid="true" @endif
    />
  </div>

  <div class="form__field">
    <label class="form__label" for="password">{{ __('Wachtwoord', 'sage') }}</label>
    <input
      class="form__input"
      type="password"
      id="password"
      name="password"
      autocomplete="new-password"
      required
      @if (isset($errors) && $errors->has('password')) aria-invalid="true" @endif
    />
  </div>

  <button class="button button--primary button--block" type="submit">
    {{ __('Account aanmaken', 'sage') }}
  </button>
</form>
