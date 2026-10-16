@props(['title' => null, 'description' => null])
@php
    $site = config('site');
    $title ??= $site['name'].' | Custom Web Systems, Payments & Integration in Malaysia';
    $description ??= 'Enigmatic Solutions designs, builds and maintains custom web-based business systems in Malaysia: payroll and billing portals, claims, booking and helpdesk platforms, FPX payment integration and legacy system migration.';
    $url = 'https://'.$site['domain'];
@endphp
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>
    <meta name="description" content="{{ $description }}">
    <link rel="canonical" href="{{ $url }}">
    <meta name="theme-color" content="#0a0a0a">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $site['name'] }}">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $url }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:image" content="{{ $url }}/images/brand/og-image.png?v={{ @filemtime(public_path('images/brand/og-image.png')) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:image" content="{{ $url }}/images/brand/og-image.png?v={{ @filemtime(public_path('images/brand/og-image.png')) }}">

    {{-- ?v= changes whenever an icon file changes, so browsers drop their cached copy --}}
    @php($iconVersion = max(array_map(fn ($f) => @filemtime(public_path($f)) ?: 0, ['favicon.ico', 'images/brand/icon-512.png', 'apple-touch-icon.png'])))
    <link rel="icon" href="/favicon.ico?v={{ $iconVersion }}" sizes="any">
    <link rel="icon" href="/images/brand/icon-512.png?v={{ $iconVersion }}" type="image/png">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png?v={{ $iconVersion }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|instrument-serif:400,400i&display=swap" rel="stylesheet">

    <script type="application/ld+json">
    {!! json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'ProfessionalService',
        'name' => $site['name'],
        'url' => $url,
        'logo' => $url.'/images/brand/icon-512.png',
        'image' => $url.'/images/brand/og-image.png',
        'email' => $site['email'],
        'telephone' => $site['phone'],
        'description' => $description,
        'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'Kajang', 'addressRegion' => 'Selangor', 'addressCountry' => 'MY'],
        'areaServed' => 'MY',
        'knowsAbout' => ['Laravel', 'Livewire', 'Web application development', 'System integration', 'FPX payment gateway', 'Data migration'],
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    @if (\App\Rules\Turnstile::enabled())
        <script src="https://challenges.cloudflare.com/turnstile/v0/api.js?render=explicit" async defer></script>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Black and gold reads best in dark mode, so first-time visitors start there. The toggle still switches to light. --}}
    <script>try { if (! localStorage.getItem('flux.appearance')) localStorage.setItem('flux.appearance', 'dark') } catch (e) {}</script>
    @fluxAppearance
</head>
<body class="min-h-screen bg-white font-sans text-neutral-900 antialiased dark:bg-ink dark:text-neutral-100">
    {{ $slot }}

    @persist('toast')
        <flux:toast position="bottom end" />
    @endpersist

    @fluxScripts
</body>
</html>
