<?php

namespace App\Livewire;

use App\Mail\ContactInquiry;
use App\Rules\Turnstile;
use Flux\Flux;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;

class ContactForm extends Component
{
    public const SERVICES = [
        'Custom business system',
        'Online payment & billing',
        'System integration & API',
        'Legacy system migration',
        'Automation & bots',
        'Dashboards & reporting',
        'Maintenance & support',
    ];

    public string $name = '';

    public string $email = '';

    public string $company = '';

    public string $phone = '';

    public string $service = '';

    public string $budget = '';

    public string $message = '';

    /** Real people need at least this many seconds to fill in the form. */
    public const MIN_SECONDS = 3;

    // Honeypot: real visitors never see or fill this field.
    public string $website = '';

    // When the form was shown. Locked so the browser cannot change it.
    #[Locked]
    public int $renderedAt = 0;

    // Cloudflare Turnstile token, filled in by the widget.
    public string $turnstileToken = '';

    public bool $sent = false;

    public function mount(): void
    {
        $this->renderedAt = now()->getTimestamp();
    }

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email:rfc|max:150',
            'company' => 'nullable|string|max:150',
            'phone' => 'nullable|string|max:30',
            'service' => ['required', Rule::in(self::SERVICES)],
            'budget' => 'nullable|string|max:50',
            'message' => 'required|string|min:20|max:3000',
            'turnstileToken' => Turnstile::enabled() ? ['required', 'string', new Turnstile] : [],
        ];
    }

    protected function messages(): array
    {
        return [
            'service.required' => 'Please choose what you need help with.',
            'turnstileToken.required' => 'Please complete the security check.',
        ];
    }

    public function submit(): void
    {
        if ($this->website !== '') {
            $this->sent = true;

            return;
        }

        // Timing check: bots submit almost instantly after the page loads.
        if (now()->getTimestamp() - $this->renderedAt < self::MIN_SECONDS) {
            $this->addError('message', 'That was very quick. Please check your details and press send again.');

            return;
        }

        try {
            $this->validate();
        } finally {
            // Turnstile tokens work only once, so get a fresh one for the next attempt.
            $this->resetTurnstile();
        }

        $key = 'contact:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $this->addError('message', 'Too many enquiries. Please try again in '.ceil(RateLimiter::availableIn($key) / 60).' minutes, or e-mail us directly.');

            return;
        }

        RateLimiter::hit($key, 600);

        try {
            Mail::to(config('site.email'))->send(new ContactInquiry($this->only([
                'name', 'email', 'company', 'phone', 'service', 'budget', 'message',
            ])));
        } catch (\Throwable $e) {
            Log::error('Contact form mail failed', ['error' => $e->getMessage()]);
            $this->addError('message', 'We could not send your message right now. Please e-mail '.config('site.email').' directly.');

            return;
        }

        $this->reset(['name', 'email', 'company', 'phone', 'service', 'budget', 'message']);
        $this->renderedAt = now()->getTimestamp();
        $this->sent = true;

        Flux::toast(heading: 'Message sent', text: 'Thank you. We will reply within one business day.', variant: 'success');
    }

    private function resetTurnstile(): void
    {
        if (Turnstile::enabled()) {
            $this->turnstileToken = '';
            $this->dispatch('turnstile-reset');
        }
    }

    public function render()
    {
        return view('livewire.contact-form', ['services' => self::SERVICES]);
    }
}
