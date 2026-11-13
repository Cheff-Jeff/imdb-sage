@props([
  'type' => null,
  'message' => null,
])

@php($modifier = in_array($type, ['success', 'caution', 'warning'], true) ? $type : 'info')

<div {{ $attributes->merge(['class' => "alert alert--{$modifier}"]) }} role="{{ $modifier === 'warning' ? 'alert' : 'status' }}">
  {!! $message ?? $slot !!}
</div>
