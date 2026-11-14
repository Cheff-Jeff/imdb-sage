{{--
  Review form, used for adding and editing.
  $action       form action URL
  $review       WP_Post when editing, null when adding
  $movieId      movie ID (only needed when adding)
  $idPrefix     unique prefix for input ids
  $submitLabel  text on the submit button
  $cancelUrl    optional: shows an "Annuleren" link
--}}
@php
  $review = $review ?? null;
  $idPrefix = $idPrefix ?? 'review';
  $rating = $review ? (int) get_field('reveiw_stars', $review->ID) : 0;
@endphp

<form class="form" action="{{ $action }}" method="post">
  @if ($review)
    <input type="hidden" name="review" value="{{ $review->ID }}" />
  @else
    <input type="hidden" name="movie" value="{{ $movieId }}" />
  @endif

  @include('partials.star-input', ['idPrefix' => $idPrefix, 'selected' => $rating])

  <div class="form__field">
    <label class="form__label" for="{{ $idPrefix }}-title">{{ __('Titel', 'sage') }}</label>
    <input
      class="form__input"
      type="text"
      id="{{ $idPrefix }}-title"
      name="title"
      value="{{ $review?->post_title }}"
      placeholder="{{ __('Vat je mening samen', 'sage') }}"
      maxlength="120"
      required
    />
  </div>

  <div class="form__field">
    <label class="form__label" for="{{ $idPrefix }}-content">{{ __('Review', 'sage') }}</label>
    <textarea
      class="form__input form__textarea"
      id="{{ $idPrefix }}-content"
      name="content"
      rows="5"
      placeholder="{{ __('Wat vond je van de film?', 'sage') }}"
      required
    >{{ $review?->post_content }}</textarea>
  </div>

  <div @class(['form__actions', 'form__actions--split' => ! empty($cancelUrl)])>
    <button @class(['button', 'button--primary', 'button--block' => empty($cancelUrl)]) type="submit">
      {{ $submitLabel }}
    </button>

    @if (! empty($cancelUrl))
      <a class="button button--ghost" href="{{ $cancelUrl }}">{{ __('Annuleren', 'sage') }}</a>
    @endif
  </div>
</form>
