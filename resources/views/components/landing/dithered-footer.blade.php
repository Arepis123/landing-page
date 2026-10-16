{{--
    Dithered footer, inspired by 21st.dev "Dithered Footer" (Ato Augustine, MIT).
    The company name is cut out of a drifting field of dithered gold dots that brighten under the cursor.
--}}
@props(['site', 'nav'])
<footer class="relative overflow-hidden border-t border-neutral-200 bg-white dark:border-white/10 dark:bg-ink">
    <div class="mx-auto max-w-7xl px-4 pt-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <a href="#top" class="inline-flex items-center gap-2.5">
                    <x-landing.logo size="h-9" />
                    <span class="font-semibold tracking-tight">{{ $site['name'] }}</span>
                </a>
                <p class="mt-4 max-w-sm text-sm text-neutral-500 dark:text-neutral-400">{{ $site['tagline'] }}. Custom systems for organisations that have outgrown spreadsheets and legacy software.</p>

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <flux:button href="#contact" variant="primary" size="sm" icon:trailing="arrow-right">Start a project</flux:button>
                    <a href="mailto:{{ $site['email'] }}" aria-label="E-mail us" class="grid size-8 place-items-center rounded-lg border border-neutral-200 text-neutral-500 transition hover:border-brand-500/60 hover:text-brand-700 dark:border-white/10 dark:text-neutral-400 dark:hover:text-brand-300">
                        <flux:icon.envelope variant="micro" />
                    </a>
                    <a href="https://wa.me/{{ $site['whatsapp'] }}" target="_blank" rel="noopener" aria-label="WhatsApp us" class="grid size-8 place-items-center rounded-lg border border-neutral-200 text-neutral-500 transition hover:border-brand-500/60 hover:text-brand-700 dark:border-white/10 dark:text-neutral-400 dark:hover:text-brand-300">
                        <flux:icon.chat-bubble-left-right variant="micro" />
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-10 text-sm sm:grid-cols-[1fr_1fr_1.5fr] lg:col-span-7">
                <div>
                    <div class="font-semibold">Company</div>
                    <ul class="mt-4 space-y-2.5 text-neutral-500 dark:text-neutral-400">
                        @foreach ($nav as $item)
                            <li><a href="{{ $item['href'] }}" class="transition hover:text-brand-700 dark:hover:text-brand-300">{{ $item['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <div class="font-semibold">Services</div>
                    <ul class="mt-4 space-y-2.5 text-neutral-500 dark:text-neutral-400">
                        <li>Business systems</li><li>FPX payments</li><li>System integration</li><li>Legacy migration</li><li>Automation &amp; bots</li>
                    </ul>
                </div>
                <div class="col-span-2 sm:col-span-1">
                    <div class="font-semibold">Contact</div>
                    <ul class="mt-4 space-y-2.5 text-neutral-500 dark:text-neutral-400">
                        <li><a href="mailto:{{ $site['email'] }}" class="break-words transition hover:text-brand-700 dark:hover:text-brand-300">{{ $site['email'] }}</a></li>
                        <li><a href="https://wa.me/{{ $site['whatsapp'] }}" class="transition hover:text-brand-700 dark:hover:text-brand-300">{{ $site['phone'] }}</a></li>
                        <li>{{ $site['location'] }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Dithered band with the cut-out company name --}}
    <div class="df-band relative mt-12 h-[clamp(5.5rem,13vw,12rem)] overflow-hidden" data-df-band aria-hidden="true">
        <div class="df-field"><div class="df-dots"></div></div>
        <p class="df-mark pointer-events-none absolute inset-x-0 -bottom-[0.06em] text-center font-bold leading-[0.8] tracking-[-0.055em] whitespace-nowrap text-white select-none dark:text-ink">
            {{ $site['name'] }}
        </p>
    </div>

    <div class="border-t border-neutral-200 dark:border-white/10">
        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-4 py-5 text-xs text-neutral-500 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
            <span>© {{ date('Y') }} {{ $site['name'] }} · SSM {{ $site['ssm'] }}</span>
            <div class="flex items-center gap-4">
                <span>{{ $site['domain'] }}</span>
                <button type="button" x-data @click="window.scrollTo({ top: 0, behavior: matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth' })"
                    class="inline-flex cursor-pointer items-center gap-1 rounded-md px-2 py-1 transition hover:bg-neutral-100 hover:text-neutral-900 dark:hover:bg-white/5 dark:hover:text-white">
                    Back to top <flux:icon.arrow-up variant="micro" class="size-3.5" />
                </button>
            </div>
        </div>
    </div>
</footer>
