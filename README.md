# Enigmatic Solutions landing page

Marketing site for enigmaticsolution.online, built on Laravel 12, Livewire, Flux UI and Flux UI Pro, Tailwind CSS 4.
Visual effects are Blade/Alpine/CSS ports of 21st.dev community components: Spotlight, Aurora background,
Border Beam, Shimmer Button, Marquee, Number Ticker, Word Rotate, Blur Fade, Spotlight Card and Dithered Footer.

## Run locally

```bash
composer install        # needs auth.json with your Flux Pro licence (git-ignored)
npm install && npm run build
php artisan serve
```

## Where to edit

| What | File |
| --- | --- |
| Company name, e-mail, phone, SSM, domain | `config/site.php` (e-mail and domain also via `.env`) |
| Page content and sections | `resources/views/welcome.blade.php` |
| Contact form and validation | `app/Livewire/ContactForm.php`, `resources/views/livewire/contact-form.blade.php` |
| Enquiry e-mail template | `resources/views/mail/contact-inquiry.blade.php` |
| Logo mark, favicon, share image | `public/images/brand/` (made from `public/Enigmatic Solutions Tech Logo.png`), shown via `resources/views/components/landing/logo.blade.php` |
| Colours and effects | `resources/css/app.css`, `resources/js/app.js` |

## Production

Enquiries are e-mailed to `CONTACT_EMAIL` (admin@enigmaticsolutions.online). Locally `MAIL_MAILER=log` writes them to
`storage/logs/laravel.log`. In production set real SMTP or Brevo credentials, for example:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://enigmaticsolution.online
MAIL_MAILER=smtp
MAIL_HOST=smtp-relay.brevo.com
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_FROM_ADDRESS=admin@enigmaticsolutions.online
```

## Contact form spam protection

- Hidden honeypot field, a 3-second minimum fill time, 3 enquiries per IP per 10 minutes, and CSRF protection.
- Cloudflare Turnstile: create a widget at dash.cloudflare.com > Turnstile for your domain, then set
  `TURNSTILE_SITE_KEY` and `TURNSTILE_SECRET_KEY` in `.env`. Leave both empty to switch Turnstile off.
  The local `.env` uses Cloudflare's test keys, which always pass and show a "For testing only" strip.

Then run `php artisan optimize` after deploying. Tests: `php artisan test`.
