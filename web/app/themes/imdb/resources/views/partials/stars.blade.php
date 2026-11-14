{{-- Read-only star rating. Pass $rating (0-5). --}}
@php($rating = max(0, min(5, (int) round($rating ?? 0))))

<span class="stars" role="img" aria-label="{{ sprintf(__('%d van 5 sterren', 'sage'), $rating) }}">
  @foreach (range(1, 5) as $i)
    <span @class(['stars__star', 'stars__star--on' => $i <= $rating])>
      @include('partials.icon-star')
    </span>
  @endforeach
</span>
