import './bootstrap';

// Scroll reveal (21st.dev "Blur Fade")
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

document.documentElement.classList.add('reveal-ready');
const initReveal = () => document.querySelectorAll('[data-reveal]:not(.is-visible)').forEach((el) => revealObserver.observe(el));

// Cursor spotlight for cards (21st.dev "Spotlight Card")
document.addEventListener('pointermove', (e) => {
    const card = e.target.closest?.('.spotlight-card');
    if (!card) return;
    const r = card.getBoundingClientRect();
    card.style.setProperty('--mx', `${e.clientX - r.left}px`);
    card.style.setProperty('--my', `${e.clientY - r.top}px`);
});

document.addEventListener('DOMContentLoaded', initReveal);
document.addEventListener('livewire:navigated', initReveal);

document.addEventListener('alpine:init', () => {
    // Number ticker (Magic UI "Number Ticker")
    window.Alpine.data('numberTicker', (target, duration = 1800) => ({
        display: '0',
        init() {
            const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const fmt = (n) => Math.round(n).toLocaleString('en-MY');
            if (reduce) { this.display = fmt(target); return; }
            const io = new IntersectionObserver(([entry]) => {
                if (!entry.isIntersecting) return;
                io.disconnect();
                const start = performance.now();
                const tick = (now) => {
                    const p = Math.min((now - start) / duration, 1);
                    this.display = fmt(target * (1 - Math.pow(1 - p, 4)));
                    if (p < 1) requestAnimationFrame(tick);
                };
                requestAnimationFrame(tick);
            }, { threshold: 0.5 });
            io.observe(this.$el);
        },
    }));

    // Word rotate (21st.dev "Word Rotate")
    window.Alpine.data('wordRotate', (count, interval = 2600) => ({
        active: 0,
        init() {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
            setInterval(() => { this.active = (this.active + 1) % count; }, interval);
        },
    }));
});

// Dithered footer: dots brighten around the cursor (21st.dev "Dithered Footer")
document.addEventListener('pointermove', (e) => {
    if (e.pointerType !== 'mouse') return;
    const band = e.target.closest?.('[data-df-band]');
    document.querySelectorAll('[data-df-band] .df-field.df-lit').forEach((f) => { if (!band || !band.contains(f)) f.classList.remove('df-lit'); });
    if (!band) return;
    const field = band.querySelector('.df-field');
    const r = band.getBoundingClientRect();
    requestAnimationFrame(() => {
        field.style.setProperty('--df-x', `${e.clientX - r.left}px`);
        field.style.setProperty('--df-y', `${e.clientY - r.top}px`);
        field.classList.add('df-lit');
    });
});

// Cloudflare Turnstile widget for the contact form
document.addEventListener('alpine:init', () => {
    window.Alpine.data('turnstile', (siteKey) => ({
        widgetId: null,
        init() {
            const render = () => {
                if (! window.turnstile) return setTimeout(render, 150);
                this.widgetId = window.turnstile.render(this.$refs.box, {
                    sitekey: siteKey,
                    size: 'flexible',
                    appearance: 'interaction-only',
                    theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                    callback: (token) => { this.$wire.turnstileToken = token; },
                    'expired-callback': () => { this.$wire.turnstileToken = ''; },
                    'error-callback': () => { this.$wire.turnstileToken = ''; },
                });
            };
            render();
        },
        reset() {
            if (this.widgetId !== null && window.turnstile) window.turnstile.reset(this.widgetId);
        },
        destroy() {
            if (this.widgetId !== null && window.turnstile) window.turnstile.remove(this.widgetId);
        },
    }));
});
