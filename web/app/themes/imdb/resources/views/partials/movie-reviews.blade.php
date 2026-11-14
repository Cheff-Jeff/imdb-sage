{{-- Reviews for a movie. Expects $reviews (Collection of WP_Post), $stats (from reviewStats()) and $hasReviews. --}}
@php
  $currentUserId = get_current_user_id();
  $ownReview = $currentUserId
    ? $reviews->first(fn ($review) => (int) $review->post_author === $currentUserId)
    : null;
@endphp

<section id="reviews" class="movie-reviews" aria-labelledby="reviews-title">
  <h2 id="reviews-title" class="section-title">{{ __('Reviews', 'sage') }}</h2>

  <div class="movie-reviews__layout">
    <aside class="movie-reviews__aside">
      {{-- Summary --}}
      <div class="review-summary">
        @if ($stats['average'] !== null)
          <p class="review-summary__score">{{ number_format_i18n($stats['average'], 1) }}<span>/5</span></p>
          @include ('partials.stars', ['rating' => $stats['average']])
        @else
          <p class="review-summary__score review-summary__score--empty">&ndash;<span>/5</span></p>
          @include ('partials.stars', ['rating' => 0])
        @endif

        <p class="review-summary__count">
          {{ sprintf(_n('%s review', '%s reviews', $stats['count'], 'sage'), number_format_i18n($stats['count'])) }}
        </p>

        @if ($stats['count'] > 0)
          <ul class="review-summary__bars">
            @foreach ($stats['breakdown'] as $rating => $total)
              <li class="review-bar">
                <span class="review-bar__label">
                  {{ $rating }}
                  @include ('partials.icon-star')
                </span>
                <progress
                  class="review-bar__meter"
                  value="{{ $total }}"
                  max="{{ max(1, $stats['count']) }}"
                  aria-label="{{ sprintf(_n('%d ster', '%d sterren', $rating, 'sage'), $rating) }}: {{ sprintf(_n('%d review', '%d reviews', $total, 'sage'), $total) }}"
                >
                  {{ $total }}
                </progress>
                <span class="review-bar__total">{{ $total }}</span>
              </li>
            @endforeach
          </ul>
        @endif
      </div>

      {{-- Write a review --}}
      <div class="review-form">
        <h3 class="review-form__title">{{ __('Schrijf een review', 'sage') }}</h3>

        @if (is_user_logged_in() && !$hasReviews)
          @include ('forms.review', [
            'action' => route('addReview'),
            'review' => null,
            'movieId' => get_the_ID(),
            'idPrefix' => 'review',
            'submitLabel' => __('Plaats review', 'sage'),
          ])
        @else
          @if ($hasReviews)
            <p class="review-form__login">{{ __('Je hebt al een review geschreven voor deze film.', 'sage') }}</p>
            @if ($ownReview)
              <a class="button button--outline button--block" href="#edit-review-{{ $ownReview->ID }}">
                {{ __('Bewerk je review', 'sage') }}
              </a>
            @endif
          @else
            <p class="review-form__login">{{ __('Log in om je mening over deze film te delen.', 'sage') }}</p>
            <a class="button button--primary button--block" href="{{ route('sign-in') }}">
              {{ __('Inloggen', 'sage') }}
            </a>
          @endif
        @endif
      </div>
    </aside>

    {{-- List --}}
    <div class="movie-reviews__list">
      @forelse ($reviews as $review)
        @php
          $authorId = (int) $review->post_author;
          $author = $authorId ? get_the_author_meta('display_name', $authorId) : '';
          $isOwn = $authorId && $authorId === $currentUserId;
        @endphp

        <article id="review-{{ $review->ID }}" @class(['review', 'review--own' => $isOwn])>
          <header class="review__header">
            <img
              class="review__avatar"
              src="{{ get_avatar_url($authorId, ['size' => 80]) }}"
              alt=""
              width="40"
              height="40"
              loading="lazy"
            />
            <div class="review__byline">
              <p class="review__author">
                {{ $author ?: __('Anoniem', 'sage') }}
                @if ($isOwn)
                  <span class="review__badge">{{ __('Jij', 'sage') }}</span>
                @endif
              </p>
              <p class="review__date">
                <time datetime="{{ get_post_time('c', true, $review) }}">
                  {{ sprintf(__('%s geleden', 'sage'), human_time_diff(get_post_time('U', true, $review), time())) }}
                </time>
              </p>
            </div>
            <div class="review__stars">
              @include ('partials.stars', ['rating' => (int) get_field('reveiw_stars', $review->ID)])
            </div>
          </header>

          <div class="review__content">
            <h3 class="review__title">{{ get_the_title($review) }}</h3>
            <div class="review__body">{!! wpautop(esc_html($review->post_content)) !!}</div>
          </div>

          @if ($isOwn)
            {{-- Shown via CSS :target when the URL ends in #edit-review-{ID} --}}
            <div id="edit-review-{{ $review->ID }}" class="review-edit">
              <h4 class="review-edit__title">{{ __('Review bewerken', 'sage') }}</h4>
              @include ('forms.review', [
                'action' => route('editReview'),
                'review' => $review,
                'idPrefix' => 'edit-review-' . $review->ID,
                'submitLabel' => __('Wijzigingen opslaan', 'sage'),
                'cancelUrl' => '#review-' . $review->ID,
              ])
            </div>

            <footer class="review__footer">
              <a class="review-action" href="#edit-review-{{ $review->ID }}">
                <svg class="review-action__icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                  <path d="m5.43 13.92-.43 2.6a.5.5 0 0 0 .58.57l2.6-.43a3 3 0 0 0 1.6-.83l6.72-6.73a2.12 2.12 0 0 0-3-3L6.27 12.32a3 3 0 0 0-.84 1.6Z"/>
                  <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z"/>
                </svg>
                {{ __('Bewerken', 'sage') }}
              </a>

              {{-- <details> gives a confirm step without JavaScript --}}
              <details class="review-delete">
                <summary class="review-delete__toggle">
                  <svg class="review-delete__icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.44c-.8.08-1.58.17-2.37.29a.75.75 0 1 0 .23 1.49l.15-.03.84 10.52A2.75 2.75 0 0 0 7.59 19h4.82a2.75 2.75 0 0 0 2.74-2.54L16 5.94l.15.03a.75.75 0 1 0 .23-1.49c-.79-.12-1.58-.21-2.38-.29v-.44A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.67.03 2.5.08v-.33c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.33C8.33 4.03 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd"/>
                  </svg>
                  <span class="review-delete__label-closed">{{ __('Verwijderen', 'sage') }}</span>
                  <span class="review-delete__label-open">{{ __('Annuleren', 'sage') }}</span>
                </summary>

                <div class="review-delete__confirm">
                  <p>{{ __('Weet je zeker dat je deze review wilt verwijderen? Dit kan niet ongedaan worden gemaakt.', 'sage') }}</p>
                  <form action="{{ route('deleteReview') }}" method="post">
                    <input type="hidden" name="review" value="{{ $review->ID }}" />
                    <button class="button button--danger" type="submit">
                      {{ __('Ja, verwijderen', 'sage') }}
                      <span class="sr-only">{{ sprintf(__('review "%s"', 'sage'), get_the_title($review)) }}</span>
                    </button>
                  </form>
                </div>
              </details>
            </footer>
          @endif
        </article>
      @empty
        <div class="movie-reviews__empty">
          @include ('partials.icon-star')
          <p>{{ __('Nog geen reviews. Wees de eerste die deze film beoordeelt!', 'sage') }}</p>
        </div>
      @endforelse
    </div>
  </div>
</section>
