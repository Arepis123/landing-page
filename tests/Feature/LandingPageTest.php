<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Mail\ContactInquiry;
use App\Rules\Turnstile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use Tests\TestCase;

class LandingPageTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        RateLimiter::clear('contact:127.0.0.1');
        // Turnstile off by default; specific tests switch it on.
        config(['services.turnstile.site_key' => null, 'services.turnstile.secret_key' => null]);
    }

    private function enableTurnstile(): void
    {
        config(['services.turnstile.site_key' => 'site-key', 'services.turnstile.secret_key' => 'secret-key']);
    }

    private function validForm(bool $wait = true)
    {
        $component = Livewire::test(ContactForm::class);

        if ($wait) {
            $this->travel(ContactForm::MIN_SECONDS + 1)->seconds();
        }

        return $component
            ->set('name', 'Aisyah Rahman')
            ->set('email', 'aisyah@example.com')
            ->set('service', 'Custom business system')
            ->set('message', 'We need a portal to replace our spreadsheet-based claims process.');
    }

    public function test_landing_page_renders_key_sections(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Enigmatic Solutions')
            ->assertSee('admin@enigmaticsolutions.online')
            ->assertSee('e-Salary')
            ->assertSee('Sistem Aduan')
            ->assertSeeLivewire(ContactForm::class);
    }

    public function test_enquiry_is_emailed_to_admin(): void
    {
        Mail::fake();

        $this->validForm()->call('submit')->assertHasNoErrors()->assertSet('sent', true);

        Mail::assertSent(ContactInquiry::class, fn ($mail) => $mail->hasTo('admin@enigmaticsolutions.online')
            && $mail->hasReplyTo('aisyah@example.com'));
    }

    public function test_invalid_enquiry_is_rejected(): void
    {
        Mail::fake();

        $component = Livewire::test(ContactForm::class);
        $this->travel(ContactForm::MIN_SECONDS + 1)->seconds();

        $component
            ->set('email', 'not-an-email')
            ->set('service', 'Something else')
            ->call('submit')
            ->assertHasErrors(['name', 'email', 'service', 'message']);

        Mail::assertNothingSent();
    }

    public function test_honeypot_blocks_bots_silently(): void
    {
        Mail::fake();

        $this->validForm()->set('website', 'http://spam.test')->call('submit')->assertSet('sent', true);

        Mail::assertNothingSent();
    }

    public function test_enquiries_are_rate_limited(): void
    {
        Mail::fake();

        foreach (range(1, 3) as $i) {
            $this->validForm()->call('submit')->assertHasNoErrors();
        }

        $this->validForm()->call('submit')->assertHasErrors('message');
        Mail::assertSentCount(3);
    }

    public function test_instant_submission_is_rejected_as_a_bot(): void
    {
        Mail::fake();

        $this->validForm(wait: false)->call('submit')->assertHasErrors('message')->assertSet('sent', false);

        Mail::assertNothingSent();
    }

    public function test_turnstile_token_is_required_when_enabled(): void
    {
        Mail::fake();
        $this->enableTurnstile();
        Http::fake();

        $this->validForm()->call('submit')->assertHasErrors(['turnstileToken' => 'required']);

        Mail::assertNothingSent();
    }

    public function test_failed_turnstile_check_blocks_the_enquiry(): void
    {
        Mail::fake();
        $this->enableTurnstile();
        Http::fake([Turnstile::VERIFY_URL => Http::response(['success' => false, 'error-codes' => ['invalid-input-response']])]);

        $this->validForm()->set('turnstileToken', 'bad-token')->call('submit')
            ->assertHasErrors('turnstileToken')
            ->assertDispatched('turnstile-reset');

        Mail::assertNothingSent();
    }

    public function test_passed_turnstile_check_sends_the_enquiry(): void
    {
        Mail::fake();
        $this->enableTurnstile();
        Http::fake([Turnstile::VERIFY_URL => Http::response(['success' => true])]);

        $this->validForm()->set('turnstileToken', 'good-token')->call('submit')->assertHasNoErrors()->assertSet('sent', true);

        Mail::assertSent(ContactInquiry::class);
        Http::assertSent(fn ($request) => $request['secret'] === 'secret-key' && $request['response'] === 'good-token');
    }
}
