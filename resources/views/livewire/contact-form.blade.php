<div>
    @if ($sent)
        <div class="flex flex-col items-center justify-center gap-4 py-16 text-center">
            <div class="grid size-14 place-items-center rounded-full bg-brand-500/15 text-brand-500 ring-1 ring-brand-500/30">
                <flux:icon.check-badge class="size-7" />
            </div>
            <flux:heading size="xl">Thank you, your message is on its way.</flux:heading>
            <flux:text class="max-w-sm">We read every enquiry personally and reply within one business day.</flux:text>
            <flux:button variant="ghost" size="sm" wire:click="$set('sent', false)" icon="arrow-path">Send another message</flux:button>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            <div class="grid gap-5 sm:grid-cols-2">
                <flux:input wire:model="name" label="Full name" placeholder="Your name" autocomplete="name" required />
                <flux:input wire:model="email" type="email" label="Work e-mail" placeholder="you@company.com" autocomplete="email" required />
                <flux:input wire:model="company" label="Company" badge="Optional" placeholder="Organisation name" autocomplete="organization" />
                <flux:input wire:model="phone" type="tel" label="Phone" badge="Optional" placeholder="+60 1X-XXX XXXX" autocomplete="tel" />
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <flux:select wire:model="service" variant="listbox" label="What do you need?" placeholder="Choose a service">
                    @foreach ($services as $item)
                        <flux:select.option value="{{ $item }}">{{ $item }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="budget" variant="listbox" label="Estimated budget" placeholder="Not sure yet" clearable>
                    <flux:select.option value="Below RM 20k">Below RM 20k</flux:select.option>
                    <flux:select.option value="RM 20k to 50k">RM 20k to 50k</flux:select.option>
                    <flux:select.option value="RM 50k to 150k">RM 50k to 150k</flux:select.option>
                    <flux:select.option value="Above RM 150k">Above RM 150k</flux:select.option>
                </flux:select>
            </div>

            <flux:textarea wire:model="message" label="Tell us about the project" rows="5" placeholder="What process are you trying to digitise, who will use it, and is there an existing system we need to connect to?" required />

            <div class="hidden" aria-hidden="true">
                <label>Leave this empty <input type="text" wire:model="website" tabindex="-1" autocomplete="off"></label>
            </div>

            @if (\App\Rules\Turnstile::enabled())
                <div>
                    <div wire:ignore x-data="turnstile(@js(config('services.turnstile.site_key')))" @turnstile-reset.window="reset()">
                        <div x-ref="box"></div>
                    </div>
                    <flux:error name="turnstileToken" />
                </div>
            @endif

            <div class="flex flex-col-reverse items-start justify-between gap-4 pt-1 sm:flex-row sm:items-center">
                <flux:text size="sm" class="flex items-center gap-1.5">
                    <flux:icon.lock-closed variant="micro" />
                    Your details are only used to reply to you.
                </flux:text>

                <button type="submit" wire:loading.attr="disabled" class="shimmer-btn group inline-flex h-11 cursor-pointer items-center gap-2 rounded-xl px-6 text-sm font-semibold text-neutral-950 disabled:opacity-70">
                    <span class="shimmer-wrap"><span class="shimmer-slide"><span class="shimmer-spin"></span></span></span>
                    <span class="shimmer-bg"></span>
                    <span wire:loading.remove wire:target="submit">Send enquiry</span>
                    <span wire:loading wire:target="submit">Sending…</span>
                    <flux:icon.paper-airplane variant="micro" class="transition group-hover:translate-x-0.5" wire:loading.remove wire:target="submit" />
                </button>
            </div>
        </form>
    @endif
</div>
