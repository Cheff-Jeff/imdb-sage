{{-- Person card for the cast archive. Pass a WP_Post as $person, or leave it out to use the loop. --}}
@php
  $person = $person ?? get_post();
  $professions = get_the_terms($person, 'post_tag') ?: [];
  $movieCount = collect(get_field('movies_casting', $person->ID) ?: [])
    ->map(fn ($row) => is_object($row['movie_post'] ?? null) ? $row['movie_post']->ID : (int) ($row['movie_post'] ?? 0))
    ->filter()
    ->unique()
    ->count();
@endphp

<article @php(post_class('person-card', $person))>
  <a class="person-card__link" href="{{ get_permalink($person) }}">
    <figure class="person-card__photo">
      @if (has_post_thumbnail($person))
        {!! get_the_post_thumbnail($person, 'medium_large', ['class' => 'person-card__image', 'alt' => '', 'loading' => 'lazy']) !!}
      @else
        @include('partials.person-placeholder')
      @endif
    </figure>

    <div class="person-card__body">
      <h2 class="person-card__name">{!! get_the_title($person) !!}</h2>

      @if ($professions)
        <p class="person-card__professions">
          {{ collect($professions)->pluck('name')->implode(' · ') }}
        </p>
      @endif

      @if ($movieCount)
        <p class="person-card__meta">
          {{ sprintf(_n('%s film', '%s films', $movieCount, 'sage'), number_format_i18n($movieCount)) }}
        </p>
      @endif
    </div>
  </a>
</article>
