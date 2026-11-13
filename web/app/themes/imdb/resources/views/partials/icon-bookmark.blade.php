<svg class="icon-bookmark" viewBox="0 0 24 24" aria-hidden="true"
  fill="{{ $filled ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" stroke-linejoin="round">
  <path d="M6 3.5h12a1 1 0 0 1 1 1v16l-7-4.5-7 4.5v-16a1 1 0 0 1 1-1Z"/>
  @unless ($filled)
    <path d="M12 7.5v6M9 10.5h6" stroke-linecap="round"/>
  @endunless
</svg>
