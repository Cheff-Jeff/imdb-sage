{{--
  Interactive star picker (radio buttons, no JavaScript).
  $idPrefix  unique prefix for the input ids, e.g. "review" or "edit-review-12"
  $selected  rating that is checked initially (0 = none)
--}}
@php($selected = (int) ($selected ?? 0))

<fieldset class="star-input">
  <legend class="form__label">{{ __('Jouw beoordeling', 'sage') }}</legend>
  {{-- Reverse order: CSS lights up the chosen star and every star before it --}}
  <div class="star-input__options">
    @foreach (range(5, 1) as $value)
      <input
        class="star-input__radio"
        type="radio"
        id="{{ $idPrefix }}-rating-{{ $value }}"
        name="rating"
        value="{{ $value }}"
        @checked($value === $selected)
        required
      />
      <label class="star-input__label" for="{{ $idPrefix }}-rating-{{ $value }}">
        @include('partials.icon-star')
        <span class="sr-only">{{ sprintf(_n('%d ster', '%d sterren', $value, 'sage'), $value) }}</span>
      </label>
    @endforeach
  </div>
</fieldset>
