{{-- Company logo mark (icon only), rendered as a CSS mask so it adapts to light and dark mode. Source: public/Enigmatic Solutions Tech Logo.png --}}
@props(['size' => 'h-9'])
<span {{ $attributes->class($size.' block aspect-[207/256] shrink-0 bg-neutral-950 dark:bg-white') }}
    role="img" aria-label="Enigmatic Solutions logo"
    style="-webkit-mask: url('/images/brand/mark.png') center / contain no-repeat; mask: url('/images/brand/mark.png') center / contain no-repeat;"></span>
