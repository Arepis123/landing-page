@php
    $site = config('site');

    $nav = [
        ['label' => 'Services', 'href' => '#services'],
        ['label' => 'Work', 'href' => '#work'],
        ['label' => 'Automation', 'href' => '#automation'],
        ['label' => 'Process', 'href' => '#process'],
        ['label' => 'FAQ', 'href' => '#faq'],
    ];

    $rotating = ['payroll', 'payments', 'claims', 'bookings', 'stock', 'helpdesk', 'paperwork'];

    $stack = ['Laravel', 'PHP', 'Livewire', 'Flux UI', 'Tailwind CSS', 'MySQL / MariaDB', 'Billplz FPX', 'Brevo', 'DomPDF', 'Laravel Excel', 'Chart.js', 'Spatie Permission', 'Pest PHP', 'Schedule-X', 'Python', 'Tesseract OCR', 'OpenAI', 'Streamlit', 'pdfplumber'];

    $stats = [
        ['value' => 8, 'suffix' => '', 'label' => 'Systems and automations running in production'],
        ['value' => 81, 'suffix' => '', 'label' => 'Data models designed across our web systems'],
        ['value' => max(1, now()->year - $site['since']), 'suffix' => ' yrs', 'label' => 'Maintaining and extending enterprise systems'],
        ['value' => 100, 'suffix' => '%', 'label' => 'Of our web systems keep a full audit trail of changes'],
    ];

    $chart = collect([42, 48, 45, 53, 58, 55, 63, 69, 66, 74, 81, 88])->map(fn ($v, $i) => [
        'date' => sprintf('%d-%02d-01', now()->year, $i + 1),
        'collected' => $v,
        'invoiced' => $v + [9, 7, 10, 8, 6, 9, 7, 6, 8, 5, 6, 4][$i],
    ])->all();

    $projects = [
        [
            'key' => 'esalary', 'icon' => 'banknotes', 'name' => 'e-Salary',
            'purpose' => 'Payroll submission and online payment collection portal',
            'summary' => 'Contractors submit monthly timesheets and overtime, receive a system-calculated invoice and pay online. Staff monitor submissions, payments and outstanding amounts across every contractor from one portal.',
            'users' => 'Contractors, admin, finance, management', 'scale' => '34 data models · 19 service modules',
            'features' => [
                'Salary engine following Malaysian rules: EPF, SOCSO table and overtime rates',
                'Online payment through Billplz FPX with callbacks and scheduled sync',
                'Pro forma invoices, tax invoices and receipts generated as PDF',
                'Automatic overdue penalties and payment reminders',
                'Five user roles, each with its own dashboard',
                'Brevo e-mail with delivery tracking and a searchable log',
            ],
            'tech' => ['Laravel', 'Livewire', 'Flux UI', 'Billplz', 'Brevo API', 'DomPDF', 'Laravel Excel'],
        ],
        [
            'key' => 'ebooking', 'icon' => 'calendar-days', 'name' => 'e-Booking',
            'purpose' => 'Resource booking and vehicle fleet management',
            'summary' => 'Replaces manual booking of meeting rooms, IT equipment and vehicles with a calendar-based workflow, and keeps a full record of how each vehicle is used and maintained.',
            'users' => 'Staff, admin, super admin', 'scale' => '19 data models · 3 asset types',
            'features' => [
                'Drag-and-drop calendar for bookings and vehicle events',
                'QR code per asset, scanned on site to complete a booking',
                'Fuel logs, odometer readings, maintenance and inspections',
                'Automatic reminders for incomplete bookings',
                'Reports in PDF, Excel and CSV with report history',
                'Granular roles and permissions per module',
            ],
            'tech' => ['Laravel', 'Livewire + Volt', 'Flux UI', 'Schedule-X', 'Chart.js', 'QR codes'],
        ],
        [
            'key' => 'etuntutan', 'icon' => 'shield-check', 'name' => 'e-Tuntutan',
            'purpose' => 'Foreign worker insurance claim management',
            'summary' => 'Manages insurance claims from the employer\'s first submission through insurer review, payment to beneficiaries and case closure, giving officers and employers one shared view of every claim.',
            'users' => 'Employers, persons-in-charge, admin', 'scale' => '10 data models · 9 notification types',
            'features' => [
                'Three claim types in one workflow, including PERKESO',
                'Configurable document checklists per claim type',
                'Review, decision and appeal workflow',
                'Payment tracking through to disbursement',
                'Automated e-mail at every stage of the claim',
                'Secure document storage for authorised users only',
            ],
            'tech' => ['Laravel', 'Livewire', 'Flux UI', 'Spatie Permission', 'DomPDF', 'Notifications'],
        ],
        [
            'key' => 'aduan', 'icon' => 'lifebuoy', 'name' => 'Sistem Aduan',
            'purpose' => 'Complaint and helpdesk ticketing system',
            'summary' => 'Every complaint becomes a numbered ticket that is routed to the right department, assigned to staff and followed until it is resolved and closed.',
            'users' => 'Staff, admin', 'scale' => '9 data models · 9 notification types',
            'features' => [
                'Automatic running ticket numbers such as TKT-'.now()->year.'-00001',
                'Seven-day resolution target with overdue indicators',
                'Assignment to one or more staff with notifications',
                'Public status page so complainants can check progress',
                'Full activity log from creation to closure',
                'Dashboard charts for ticket volume and status',
            ],
            'tech' => ['Laravel', 'Livewire', 'Flux UI', 'Chart.js', 'Laravel Mail', 'Scheduler'],
        ],
        [
            'key' => 'stock', 'icon' => 'archive-box', 'name' => 'Stock Inventory',
            'purpose' => 'Safety equipment stock and distribution system',
            'summary' => 'Tracks safety helmets and t-shirts from central stock to regional centres and out to contractors, so every item handed out is counted and every centre\'s balance is known.',
            'users' => 'Staff, admin', 'scale' => '9 data models · 6 admin modules',
            'features' => [
                'Helmets and t-shirts tracked separately across regions and warehouses',
                'Distribution form that deducts from central stock or regional centre storage',
                'Stock availability checked before every distribution is saved',
                'QR codes for distribution, scanned on site, with rate limiting',
                'Full stock history for every adjustment',
                'Analytics dashboard, with Excel and PDF export of distributions',
            ],
            'tech' => ['Laravel', 'Livewire + Volt', 'Flux UI Pro', 'QR codes', 'PhpSpreadsheet', 'DomPDF'],
        ],
    ];

    $automations = [
        [
            'key' => 'epass', 'icon' => 'cpu-chip', 'name' => 'ePass TP Upload Bot', 'tag' => 'Scheduled bot',
            'summary' => 'Runs every morning on its own. It reads worker ePass and Green Card PDFs, files each one under the right worker, uploads it, updates the record and tells the contractor.',
            'flow' => ['Read PDFs', 'Extract passport & expiry', 'Rename', 'FTP upload', 'API update', 'Email contractor'],
            'features' => [
                'Reads passport no, name, nationality, VP no, expiry and years in Malaysia',
                'Renames files to a standard format, e.g. passport - name - 8Y_ePass.pdf',
                'Daily scheduler, plus a one-click manual run',
                'Excel run report and dated Done / Failed archive',
            ],
            'tech' => ['Python', 'pdfplumber', 'PyMySQL', 'FTP', 'REST API', 'SMTP'],
        ],
        [
            'key' => 'payslip', 'icon' => 'scissors', 'name' => 'Payslip PDF Splitter', 'tag' => 'Feeds e-Salary',
            'summary' => 'Turns one bulk payroll PDF into individual payslips, groups them by contractor and publishes them to e-Salary so contractors can download them.',
            'flow' => ['Bulk PDF', 'Split per worker', 'Match contractor', 'FTP upload', 'Notify e-Salary'],
            'features' => [
                'Reads name, department, IC / passport and pay period from every page',
                'Looks up each worker\'s contractor through the e-Salary API',
                'Uploads and notifies e-Salary to publish the payslips',
                'Desktop app and web version, with an Excel report',
            ],
            'tech' => ['Python', 'pypdf', 'pdfplumber', 'FTP', 'REST API', 'openpyxl'],
        ],
        [
            'key' => 'validator', 'icon' => 'document-magnifying-glass', 'name' => 'Document Validator', 'tag' => 'OCR + AI',
            'summary' => 'Checks thousands of safety certificates in one run. It downloads each document, reads it with OCR and confirms it was issued by an approved body.',
            'flow' => ['Excel of links', 'Download', 'OCR', 'Match issuer', 'AI second check', 'Report'],
            'features' => [
                'Recognises 12 safety passport issuers, SKK certificates and approved agencies',
                'Fixes rotated scans and tolerates typos with fuzzy matching',
                'AI vision double-checks documents OCR is unsure about',
                'Parallel processing, caching, and Excel + HTML reports in a web UI',
            ],
            'tech' => ['Python', 'Tesseract OCR', 'OpenAI', 'Streamlit', 'Plotly', 'pandas'],
        ],
    ];

    $matrix = [
        ['Role-based access control', [1, 1, 1, 1, 0]],
        ['Automated e-mail notifications', [1, 1, 1, 1, 0]],
        ['Dashboards and statistics', [1, 1, 1, 1, 1]],
        ['Activity and audit trail', [1, 1, 1, 1, 1]],
        ['Secure file upload and storage', [1, 1, 1, 1, 0]],
        ['Scheduled reminders and background jobs', [1, 1, 0, 1, 0]],
        ['PDF document generation', [1, 1, 1, 0, 1]],
        ['Excel and CSV export', [1, 1, 0, 0, 1]],
        ['Online payment gateway', [1, 0, 0, 0, 0]],
        ['External system and API integration', [1, 0, 0, 0, 0]],
        ['QR code workflow', [0, 1, 0, 0, 1]],
    ];

    $process = [
        ['title' => 'Assess', 'icon' => 'magnifying-glass', 'text' => 'We review your current process, data and any existing system, so scope and risks are clear before work begins.'],
        ['title' => 'Design', 'icon' => 'squares-2x2', 'text' => 'We map roles, workflows, notifications and reports, then agree screens with the people who will use them.'],
        ['title' => 'Build', 'icon' => 'code-bracket', 'text' => 'We build on current, supported Laravel and PHP releases with proven components for login, roles, documents and reporting, under Git with automated tests.'],
        ['title' => 'Migrate and integrate', 'icon' => 'arrows-right-left', 'text' => 'We move existing data and connect legacy databases and third-party services, checked in a staging environment first.'],
        ['title' => 'Launch and hand over', 'icon' => 'rocket-launch', 'text' => 'We go live with documentation and user training, then stay on to maintain and extend the system.'],
    ];

    $modernise = [
        ['Secure login', 'Readable passwords, no session timeout', 'Hashed passwords, session expiry, 2FA for admins'],
        ['Access control', 'Users can raise their own access', 'Server-side roles and permissions'],
        ['Audit trail', 'No record of who did what', 'Activity log and per-record history'],
        ['E-mail', 'Fails silently', 'Delivery tracking and a searchable log'],
        ['Mobile', 'Unusable on a phone', 'Responsive screens and QR scanning'],
        ['Releases', 'Files copied and dated, tested on live data', 'Git, automated tests and a staging environment'],
    ];

    $faqs = [
        ['q' => 'What kind of systems do you build?', 'a' => 'Custom web-based business systems that replace manual or spreadsheet processes: submissions, approvals, claims, bookings, ticketing, invoicing and payment collection, with dashboards and reports for management.'],
        ['q' => 'Can you take over or replace an existing system?', 'a' => 'Yes. We have maintained an older enterprise system since '.$site['since'].' and assessed its code and server configuration in full. We plan migrations around your live operations and check migrated data against the old system before go-live.'],
        ['q' => 'Which payment gateways do you work with?', 'a' => 'Billplz (FPX online banking) runs in production in e-Salary, including gateway callbacks, scheduled status sync and reconciliation. Other gateways with an API can be integrated using the same approach.'],
        ['q' => 'Can you automate repetitive document work?', 'a' => 'Yes. We build Python bots that read PDFs and scanned documents, rename and file them, upload them, update your systems through their APIs and email the right people, on a schedule or on demand. Our bots handle worker passes, payslips and safety certificates in daily production.'],
        ['q' => 'How long does a project take?', 'a' => 'It depends on scope. Login, roles and permissions, notifications, document handling and reporting are already built and proven in our systems, so much of the groundwork is done. You receive a timeline after the assessment.'],
        ['q' => 'How do you keep systems secure?', 'a' => 'Hashed passwords and session expiry, server-side roles and permissions, CSRF protection, e-mail verification, activity logs, HTTPS enforced, databases kept off the public internet, and two-factor authentication for administrators.'],
        ['q' => 'What happens after launch?', 'a' => 'We provide documentation, user training and a proper handover so the system does not depend on one or two people. We also offer ongoing maintenance and new features as your needs grow.'],
    ];
@endphp

<x-layouts.landing>

    {{-- ============ NAVBAR ============ --}}
    <header x-data="{ scrolled: false }" x-init="scrolled = window.scrollY > 8" @scroll.window="scrolled = window.scrollY > 8"
        class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
        :class="scrolled ? 'border-b border-neutral-200/70 bg-white/75 backdrop-blur-xl dark:border-white/10 dark:bg-ink/70' : 'border-b border-transparent'">
        <div class="mx-auto flex h-16 max-w-7xl items-center gap-4 px-4 sm:px-6 lg:px-8">
            <a href="#top" class="flex items-center gap-2.5" aria-label="{{ $site['name'] }} home">
                <x-landing.logo size="h-8" />
                <span class="text-[15px] font-semibold tracking-tight">Enigmatic<span class="text-neutral-400"> Solutions</span></span>
            </a>

            <flux:navbar class="-mb-px ms-6 max-md:hidden">
                @foreach ($nav as $item)
                    <flux:navbar.item href="{{ $item['href'] }}">{{ $item['label'] }}</flux:navbar.item>
                @endforeach
            </flux:navbar>

            <flux:spacer />

            <flux:button x-data x-on:click="$flux.dark = ! $flux.dark" variant="subtle" square size="sm" aria-label="Toggle dark mode">
                <flux:icon.moon variant="mini" class="dark:hidden" />
                <flux:icon.sun variant="mini" class="hidden dark:block" />
            </flux:button>

            <flux:button href="#contact" variant="primary" size="sm" icon:trailing="arrow-right" class="max-sm:hidden">Start a project</flux:button>

            <flux:dropdown position="bottom" align="end" class="md:hidden">
                <flux:button variant="subtle" square size="sm" icon="bars-3" aria-label="Open menu" />
                <flux:menu>
                    @foreach ($nav as $item)
                        <flux:menu.item href="{{ $item['href'] }}">{{ $item['label'] }}</flux:menu.item>
                    @endforeach
                    <flux:menu.separator />
                    <flux:menu.item href="#contact" icon="paper-airplane">Start a project</flux:menu.item>
                </flux:menu>
            </flux:dropdown>
        </div>
    </header>

    <main id="top">

        {{-- ============ HERO ============ --}}
        <section class="noise relative isolate overflow-hidden pt-32 pb-20 sm:pt-40">
            {{-- Background: grid + aurora + spotlight (21st.dev Spotlight / Aurora Background) --}}
            <div class="bg-grid mask-radial absolute inset-0 -z-10 text-neutral-900 dark:text-white"></div>
            <div class="pointer-events-none absolute inset-0 -z-10 overflow-hidden">
                <div class="animate-aurora absolute -top-40 left-1/2 h-[38rem] w-[60rem] -translate-x-1/2 rounded-full blur-3xl" style="background: radial-gradient(closest-side, rgb(212 160 23 / .22), transparent)"></div>
                <div class="animate-aurora absolute top-40 -right-40 h-[30rem] w-[30rem] rounded-full blur-3xl [animation-delay:-6s]" style="background: radial-gradient(closest-side, rgb(163 163 163 / .14), transparent)"></div>
            </div>
            <svg class="animate-spotlight pointer-events-none absolute top-0 left-0 -z-10 hidden h-[169%] w-[84%] opacity-0 lg:block" viewBox="0 0 3787 2842" fill="none" aria-hidden="true">
                <g filter="url(#spot-f)"><ellipse cx="1924.71" cy="273.501" rx="1924.71" ry="273.501" transform="matrix(-0.822377 -0.568943 -0.568943 0.822377 3631.88 2291.09)" class="fill-brand-100/50 dark:fill-brand-200/[0.08]"/></g>
                <defs><filter id="spot-f" x="0.860352" y="0.838989" width="3785.16" height="2840.26" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB"><feFlood flood-opacity="0" result="BackgroundImageFix"/><feBlend mode="normal" in="SourceGraphic" in2="BackgroundImageFix" result="shape"/><feGaussianBlur stdDeviation="151" result="effect1_foregroundBlur"/></filter></defs>
            </svg>

            <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
                <a href="#work" data-reveal class="group mx-auto inline-flex items-center gap-2 rounded-full border border-neutral-200 bg-white/70 py-1 ps-1 pe-3 text-xs font-medium text-neutral-600 shadow-sm backdrop-blur transition hover:border-brand-400/60 dark:border-white/10 dark:bg-white/5 dark:text-neutral-300">
                    <span class="rounded-full bg-brand-500/15 px-2 py-0.5 whitespace-nowrap text-brand-800 dark:text-brand-300">8 systems live</span>
                    <span class="sm:hidden">Trusted in construction</span><span class="max-sm:hidden">Trusted by a national construction workforce organisation</span>
                    <flux:icon.arrow-right variant="micro" class="transition group-hover:translate-x-0.5" />
                </a>

                <h1 data-reveal style="--delay:80ms" class="mx-auto mt-8 max-w-5xl text-4xl font-semibold tracking-tight text-balance sm:text-6xl lg:text-7xl">
                    Business systems that run your
                    <span x-data="wordRotate({{ count($rotating) }})" class="word-rotate font-display font-normal italic">
                        @foreach ($rotating as $i => $word)
                            <span class="pe-2 text-brand-700 dark:text-brand-300 {{ $i ? 'translate-y-full opacity-0' : '' }}"
                                :class="active === {{ $i }} ? 'translate-y-0! opacity-100! blur-none' : ((active + 1) % {{ count($rotating) }} === {{ $i }} ? 'translate-y-full! opacity-0! blur-sm' : '-translate-y-full! opacity-0! blur-sm')"><span class="dark:text-gradient">{{ $word }}.</span></span>
                        @endforeach
                    </span>
                </h1>

                <p data-reveal style="--delay:160ms" class="mx-auto mt-6 max-w-2xl text-base text-pretty text-neutral-600 sm:text-lg dark:text-neutral-400">
                    We design, build and maintain custom web applications that digitise manual work, take payments online and connect to the systems you already run. Malaysian rules built in, enterprise security as standard.
                </p>

                <div data-reveal style="--delay:240ms" class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a href="#contact" class="shimmer-btn group inline-flex h-12 items-center gap-2 rounded-xl px-7 text-sm font-semibold text-neutral-950">
                        <span class="shimmer-wrap"><span class="shimmer-slide"><span class="shimmer-spin"></span></span></span>
                        <span class="shimmer-bg"></span>
                        Start a project
                        <flux:icon.arrow-right variant="micro" class="transition group-hover:translate-x-0.5" />
                    </a>
                    <flux:button href="#work" variant="ghost" icon="play-circle" class="h-12! px-6!">See our work</flux:button>
                </div>

                {{-- Product preview with Border Beam + Flux Pro chart --}}
                <div data-reveal style="--delay:320ms" class="relative mx-auto mt-20 max-w-5xl">
                    <div class="absolute -inset-x-10 -top-10 -bottom-20 -z-10 rounded-[3rem] bg-gradient-to-b from-brand-500/20 via-brand-500/5 to-transparent blur-2xl"></div>
                    <div class="relative rounded-2xl border border-neutral-200 bg-white/80 p-2 text-left shadow-2xl shadow-brand-900/10 backdrop-blur-xl dark:border-white/10 dark:bg-charcoal/60 dark:shadow-black/40">
                        <div class="border-beam" style="--beam-size: 220px"></div>
                        <div class="rounded-xl border border-neutral-200/80 bg-white dark:border-white/5 dark:bg-ink/80">
                            <div class="flex items-center gap-2 border-b border-neutral-200/80 px-4 py-3 dark:border-white/5">
                                <span class="size-2.5 rounded-full bg-neutral-300 dark:bg-neutral-700"></span>
                                <span class="size-2.5 rounded-full bg-neutral-300 dark:bg-neutral-700"></span>
                                <span class="size-2.5 rounded-full bg-neutral-300 dark:bg-neutral-700"></span>
                                <div class="mx-auto flex items-center gap-1.5 rounded-md bg-neutral-100 px-3 py-1 text-[11px] text-neutral-500 dark:bg-white/5 dark:text-neutral-400">
                                    <flux:icon.lock-closed variant="micro" class="size-3" /> portal.yourcompany.my/dashboard
                                </div>
                            </div>
                            <div class="grid gap-4 p-4 sm:p-6 lg:grid-cols-[1fr_15rem]">
                                <div>
                                    <div class="flex flex-wrap items-end justify-between gap-2">
                                        <div>
                                            <flux:text size="sm">Collections, last 12 months</flux:text>
                                            <div class="mt-1 text-2xl font-semibold tracking-tight">RM 742k <span class="ms-1 align-middle text-xs font-medium text-emerald-600 dark:text-emerald-400">▲ 18.4%</span></div>
                                        </div>
                                        <div class="flex gap-3 text-xs text-neutral-500">
                                            <span class="flex items-center gap-1.5"><span class="size-2 rounded-full bg-brand-500"></span>Collected</span>
                                            <span class="flex items-center gap-1.5"><span class="size-2 rounded-full bg-neutral-400"></span>Invoiced</span>
                                        </div>
                                    </div>
                                    <flux:chart :value="$chart" class="mt-4 aspect-[3/1]">
                                        <flux:chart.svg>
                                            <flux:chart.line field="invoiced" class="text-neutral-400 dark:text-neutral-500" curve="smooth" stroke-dasharray="4 4" />
                                            <flux:chart.line field="collected" class="text-brand-500" curve="smooth" />
                                            <flux:chart.area field="collected" class="text-brand-500/15" curve="smooth" />
                                            <flux:chart.axis axis="x" field="date" :format="['month' => 'short']">
                                                <flux:chart.axis.tick />
                                            </flux:chart.axis>
                                            <flux:chart.axis axis="y" tick-count="4">
                                                <flux:chart.axis.grid class="text-neutral-200 dark:text-white/5" />
                                            </flux:chart.axis>
                                            <flux:chart.cursor />
                                        </flux:chart.svg>
                                        <flux:chart.tooltip>
                                            <flux:chart.tooltip.heading field="date" :format="['month' => 'long', 'year' => 'numeric']" />
                                            <flux:chart.tooltip.value field="collected" label="Collected (RM k)" />
                                            <flux:chart.tooltip.value field="invoiced" label="Invoiced (RM k)" />
                                        </flux:chart.tooltip>
                                    </flux:chart>
                                </div>
                                <div class="grid grid-cols-2 gap-3 lg:grid-cols-1">
                                    @foreach ([
                                        ['Submissions', '1,284', 'document-check', 'bg-brand-500/12 text-brand-700 dark:text-brand-400'],
                                        ['Paid via FPX', '96.2%', 'credit-card', 'bg-brand-500/12 text-brand-700 dark:text-brand-400'],
                                        ['Open tickets', '12', 'inbox-stack', 'bg-brand-500/12 text-brand-700 dark:text-brand-400'],
                                        ['E-mails delivered', '99.8%', 'envelope-open', 'bg-brand-500/12 text-brand-700 dark:text-brand-400'],
                                    ] as [$label, $value, $icon, $color])
                                        <div class="flex items-center gap-3 rounded-lg border border-neutral-200/80 p-3 dark:border-white/5">
                                            <div class="grid size-9 shrink-0 place-items-center rounded-md {{ $color }}">
                                                <flux:icon :icon="$icon" variant="mini" />
                                            </div>
                                            <div class="min-w-0">
                                                <div class="truncate text-xs text-neutral-500">{{ $label }}</div>
                                                <div class="font-semibold">{{ $value }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-4 text-center text-xs text-neutral-400">Sample dashboard with illustrative data</p>
                </div>
            </div>
        </section>

        {{-- ============ TECH MARQUEE (Magic UI Marquee) ============ --}}
        <section aria-label="Technology we use" class="border-y border-neutral-200/70 py-8 dark:border-white/5">
            <p class="mb-6 text-center text-xs font-medium tracking-[0.2em] text-neutral-500 uppercase">Built on a modern, supported stack</p>
            <div class="mask-fade-x group flex overflow-hidden [--gap:3rem]">
                @for ($copy = 0; $copy < 2; $copy++)
                    <ul class="animate-marquee flex shrink-0 items-center gap-12 pe-12 group-hover:[animation-play-state:paused]" @if ($copy) aria-hidden="true" @endif>
                        @foreach ($stack as $tech)
                            <li class="flex items-center gap-2 text-base font-semibold whitespace-nowrap text-neutral-400 transition hover:text-neutral-900 dark:text-neutral-500 dark:hover:text-white">
                                <span class="size-1.5 rounded-full bg-brand-500/70"></span>{{ $tech }}
                            </li>
                        @endforeach
                    </ul>
                @endfor
            </div>
        </section>

        {{-- ============ STATS (Number Ticker) ============ --}}
        <section class="py-20 sm:py-24">
            <div class="mx-auto grid max-w-7xl grid-cols-2 gap-px overflow-hidden rounded-2xl border border-neutral-200 bg-neutral-200 px-0 sm:mx-6 lg:mx-auto lg:grid-cols-4 dark:border-white/10 dark:bg-white/10 max-sm:mx-4">
                @foreach ($stats as $i => $stat)
                    <div data-reveal style="--delay:{{ $i * 80 }}ms" class="bg-white p-6 sm:p-8 dark:bg-ink">
                        <div class="text-4xl font-semibold tracking-tight sm:text-5xl">
                            <span x-data="numberTicker({{ $stat['value'] }})" x-text="display">{{ $stat['value'] }}</span><span class="text-brand-700 dark:text-brand-400">{{ $stat['suffix'] }}</span>
                        </div>
                        <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- ============ SERVICES (Bento Grid + Spotlight Cards) ============ --}}
        <section id="services" class="relative py-20 sm:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-reveal class="mx-auto max-w-2xl text-center">
                    <flux:badge size="sm" class="rounded-full! bg-brand-500/15! text-brand-800! dark:text-brand-300!">What we deliver</flux:badge>
                    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-balance sm:text-5xl">Everything your operation needs, <span class="font-display font-normal italic text-brand-700 dark:text-brand-400">in one system.</span></h2>
                    <p class="mt-4 text-neutral-600 dark:text-neutral-400">From the first submission to the final report, we build the whole workflow, not just the screens.</p>
                </div>

                <div class="mt-16 grid gap-4 md:grid-cols-6">
                    {{-- Custom business systems --}}
                    <div data-reveal class="spotlight-card group overflow-hidden rounded-2xl border border-neutral-200 bg-neutral-50/60 p-6 md:col-span-4 sm:p-8 dark:border-white/10 dark:bg-white/[0.03]">
                        <flux:icon.squares-plus class="size-6 text-brand-700 dark:text-brand-400" />
                        <h3 class="mt-4 text-xl font-semibold">Custom business systems</h3>
                        <p class="mt-2 max-w-md text-neutral-600 dark:text-neutral-400">End-to-end web applications that digitise manual processes: submissions, approvals, tracking, reporting and case closure.</p>
                        <div class="mt-8 flex flex-wrap items-center gap-2 text-xs font-medium">
                            @foreach (['Submitted', 'Reviewed', 'Approved', 'Paid', 'Closed'] as $i => $step)
                                <span class="rounded-full border px-3 py-1.5 transition duration-500 {{ $i < 3 ? 'border-brand-500/40 bg-brand-500/10 text-brand-800 dark:text-brand-300' : 'border-neutral-200 bg-white text-neutral-500 group-hover:border-brand-500/40 group-hover:bg-brand-500/10 group-hover:text-brand-800 dark:border-white/10 dark:bg-white/5 dark:group-hover:text-brand-300' }}" style="transition-delay: {{ $i * 90 }}ms">{{ $step }}</span>
                                @if (! $loop->last)<flux:icon.chevron-right variant="micro" class="text-neutral-300 dark:text-neutral-600" />@endif
                            @endforeach
                        </div>
                    </div>

                    {{-- Payments --}}
                    <div data-reveal style="--delay:80ms" class="spotlight-card overflow-hidden rounded-2xl border border-neutral-200 bg-neutral-50/60 p-6 md:col-span-2 sm:p-8 dark:border-white/10 dark:bg-white/[0.03]">
                        <flux:icon.credit-card class="size-6 text-brand-700 dark:text-brand-400" />
                        <h3 class="mt-4 text-xl font-semibold">Online payment and billing</h3>
                        <p class="mt-2 text-neutral-600 dark:text-neutral-400">FPX gateway integration, automated invoices, tax invoices, receipts and payment reconciliation.</p>
                        <div class="mt-6 flex items-center justify-between rounded-xl border border-neutral-200 bg-white p-3 text-sm dark:border-white/10 dark:bg-ink">
                            <span class="flex items-center gap-2"><span class="grid size-7 place-items-center rounded-md bg-brand-500/15 text-brand-700 dark:text-brand-400"><flux:icon.check variant="micro" /></span>INV-0482</span>
                            <span class="font-semibold">RM 12,480.00</span>
                        </div>
                    </div>

                    @foreach ([
                        ['arrows-right-left', 'Integration with existing systems', 'Connect new applications to legacy databases and third-party services through secure APIs and webhooks.'],
                        ['finger-print', 'Access control and audit', 'Role and permission-based access, activity logs and e-mail delivery tracking for full accountability.'],
                        ['bell-alert', 'Automation and notifications', 'Scheduled jobs for reminders, deadlines and penalties, plus e-mail at every workflow stage.'],
                    ] as $i => [$icon, $title, $text])
                        <div data-reveal style="--delay:{{ $i * 80 }}ms" class="spotlight-card rounded-2xl border border-neutral-200 bg-neutral-50/60 p-6 md:col-span-2 sm:p-8 dark:border-white/10 dark:bg-white/[0.03]">
                            <flux:icon :icon="$icon" class="size-6 text-brand-700 dark:text-brand-400" />
                            <h3 class="mt-4 text-xl font-semibold">{{ $title }}</h3>
                            <p class="mt-2 text-neutral-600 dark:text-neutral-400">{{ $text }}</p>
                        </div>
                    @endforeach

                    {{-- Reporting --}}
                    <div data-reveal class="spotlight-card overflow-hidden rounded-2xl border border-neutral-200 bg-neutral-50/60 p-6 md:col-span-6 sm:p-8 dark:border-white/10 dark:bg-white/[0.03]">
                        <div class="grid items-center gap-8 md:grid-cols-2">
                            <div>
                                <flux:icon.chart-bar-square class="size-6 text-brand-700 dark:text-brand-400" />
                                <h3 class="mt-4 text-xl font-semibold">Reporting and dashboards</h3>
                                <p class="mt-2 max-w-md text-neutral-600 dark:text-neutral-400">Management dashboards with charts and KPIs, and one-click exports to PDF, Excel and CSV.</p>
                                <div class="mt-6 flex gap-2">
                                    @foreach (['PDF', 'Excel', 'CSV'] as $fmt)
                                        <flux:badge size="sm" icon="arrow-down-tray">{{ $fmt }}</flux:badge>
                                    @endforeach
                                </div>
                            </div>
                            <div class="flex h-40 items-end gap-2" aria-hidden="true">
                                @foreach ([38, 52, 44, 66, 58, 74, 62, 86, 78, 92, 84, 100] as $i => $h)
                                    <div class="flex-1 rounded-t-md bg-gradient-to-t from-brand-600/70 to-brand-400/90 transition-all duration-700 hover:from-brand-400 hover:to-brand-200" style="height: {{ $h }}%"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============ WORK (Flux Pro Tabs) ============ --}}
        <section id="work" class="relative bg-neutral-50 py-20 sm:py-28 dark:bg-charcoal/40">
            <div class="bg-dots absolute inset-0 text-neutral-900 [mask-image:linear-gradient(to_bottom,transparent,#000_30%,#000_70%,transparent)] dark:text-white"></div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-reveal class="flex flex-col justify-between gap-6 md:flex-row md:items-end">
                    <div class="max-w-2xl">
                        <flux:badge size="sm" class="rounded-full! bg-brand-500/15! text-brand-800! dark:text-brand-300!">Selected work</flux:badge>
                        <h2 class="mt-4 text-3xl font-semibold tracking-tight text-balance sm:text-5xl">Five systems, <span class="font-display font-normal italic text-brand-700 dark:text-brand-400">in daily use.</span></h2>
                        <p class="mt-4 text-neutral-600 dark:text-neutral-400">Each one built for a national construction workforce organisation on the same platform, so they share one design, one access model and one way of working.</p>
                    </div>
                </div>

                <div data-reveal class="mt-12">
                    <flux:tab.group>
                        <div class="-mx-4 overflow-x-auto px-4 pb-1">
                            <flux:tabs variant="segmented" class="w-max min-w-full sm:min-w-0">
                                @foreach ($projects as $p)
                                    <flux:tab name="{{ $p['key'] }}" icon="{{ $p['icon'] }}">{{ $p['name'] }}</flux:tab>
                                @endforeach
                            </flux:tabs>
                        </div>

                        @foreach ($projects as $p)
                            <flux:tab.panel name="{{ $p['key'] }}" class="pt-6!">
                                <div class="spotlight-card grid gap-8 overflow-hidden rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm sm:p-10 lg:grid-cols-5 dark:border-white/10 dark:bg-ink">
                                    <div class="lg:col-span-2">
                                        <div class="flex items-center gap-3">
                                            <div class="grid size-11 place-items-center rounded-xl bg-gradient-to-br from-brand-400 to-brand-700 text-white shadow-lg shadow-brand-600/30">
                                                <flux:icon :icon="$p['icon']" variant="mini" />
                                            </div>
                                            <div>
                                                <h3 class="text-2xl font-semibold tracking-tight">{{ $p['name'] }}</h3>
                                                <p class="text-sm text-neutral-500">{{ $p['purpose'] }}</p>
                                            </div>
                                        </div>
                                        <p class="mt-6 text-neutral-600 dark:text-neutral-300">{{ $p['summary'] }}</p>

                                        <dl class="mt-8 grid grid-cols-3 gap-4 border-t border-neutral-200 pt-6 text-sm dark:border-white/10">
                                            <div><dt class="text-xs tracking-wider text-neutral-500 uppercase">Sector</dt><dd class="mt-1 font-medium">Construction</dd></div>
                                            <div><dt class="text-xs tracking-wider text-neutral-500 uppercase">Users</dt><dd class="mt-1 font-medium">{{ $p['users'] }}</dd></div>
                                            <div><dt class="text-xs tracking-wider text-neutral-500 uppercase">Scale</dt><dd class="mt-1 font-medium">{{ $p['scale'] }}</dd></div>
                                        </dl>

                                        <div class="mt-6 flex flex-wrap gap-1.5">
                                            @foreach ($p['tech'] as $t)
                                                <flux:badge size="sm" class="rounded-full! bg-brand-500/12! text-brand-800! dark:text-brand-200!">{{ $t }}</flux:badge>
                                            @endforeach
                                        </div>
                                    </div>

                                    <ul class="grid content-start gap-3 sm:grid-cols-2 lg:col-span-3">
                                        @foreach ($p['features'] as $f)
                                            <li class="flex gap-3 rounded-xl border border-neutral-200/80 bg-neutral-50/70 p-4 text-sm dark:border-white/5 dark:bg-white/[0.03]">
                                                <flux:icon.check-circle variant="mini" class="mt-px shrink-0 text-brand-700 dark:text-brand-400" />
                                                <span class="text-neutral-700 dark:text-neutral-300">{{ $f }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </flux:tab.panel>
                        @endforeach
                    </flux:tab.group>
                </div>

                {{-- Capability matrix --}}
                <div data-reveal class="mt-16">
                    <div class="flex items-baseline justify-between gap-4"><h3 class="text-lg font-semibold">Capabilities across our web systems</h3><span class="text-xs text-neutral-500 sm:hidden">Swipe to see all →</span></div>
                    <div class="relative mt-4 overflow-hidden rounded-2xl border border-neutral-200 bg-white dark:border-white/10 dark:bg-ink">
                        <flux:table>
                            <flux:table.columns>
                                <flux:table.column class="ps-6!">Capability</flux:table.column>
                                @foreach ($projects as $p)
                                    <flux:table.column align="center">{{ $p['name'] }}</flux:table.column>
                                @endforeach
                            </flux:table.columns>
                            <flux:table.rows>
                                @foreach ($matrix as [$cap, $flags])
                                    <flux:table.row>
                                        <flux:table.cell class="ps-6! font-medium whitespace-nowrap text-neutral-700 dark:text-neutral-200">{{ $cap }}</flux:table.cell>
                                        @foreach ($flags as $f)
                                            <flux:table.cell align="center">
                                                @if ($f)
                                                    <span class="relative inline-grid size-6 place-items-center rounded-full bg-brand-500/15 text-brand-700 dark:text-brand-400"><flux:icon.check variant="micro" /><span class="sr-only">Yes</span></span>
                                                @else
                                                    <span class="text-neutral-300 dark:text-neutral-600" aria-label="No">–</span>
                                                @endif
                                            </flux:table.cell>
                                        @endforeach
                                    </flux:table.row>
                                @endforeach
                            </flux:table.rows>
                        </flux:table>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============ AUTOMATION (Python bots) ============ --}}
        <section id="automation" class="relative overflow-hidden py-20 sm:py-28">
            <div class="bg-dots absolute inset-0 text-neutral-900 [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000,transparent)] dark:text-white"></div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-reveal class="mx-auto max-w-2xl text-center">
                    <flux:badge size="sm" class="rounded-full! bg-brand-500/15! text-brand-800! dark:text-brand-300!">Automation &amp; bots</flux:badge>
                    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-balance sm:text-5xl">Paperwork that <span class="font-display font-normal italic text-brand-700 dark:text-brand-400">handles itself.</span></h2>
                    <p class="mt-4 text-neutral-600 dark:text-neutral-400">Python tools that read documents, move files and update systems on their own, so staff stop renaming PDFs and checking certificates by hand.</p>
                </div>

                <div class="mt-14 grid gap-5 lg:grid-cols-3">
                    @foreach ($automations as $i => $a)
                        <article data-reveal style="--delay:{{ $i * 100 }}ms" class="spotlight-card flex flex-col overflow-hidden rounded-2xl border border-neutral-200 bg-white p-6 shadow-sm sm:p-7 dark:border-white/10 dark:bg-charcoal/60">
                            <div class="flex items-start justify-between gap-3">
                                <div class="grid size-11 place-items-center rounded-xl bg-gradient-to-br from-brand-300 to-brand-600 text-neutral-950 shadow-lg shadow-brand-600/25">
                                    <flux:icon :icon="$a['icon']" variant="mini" />
                                </div>
                                <span class="inline-flex items-center gap-1.5 rounded-full border border-neutral-200 px-2.5 py-1 text-[11px] font-medium text-neutral-600 dark:border-white/10 dark:text-neutral-300">
                                    <span class="relative flex size-1.5"><span class="absolute inline-flex size-full animate-ping rounded-full bg-emerald-400 opacity-75"></span><span class="relative inline-flex size-1.5 rounded-full bg-emerald-500"></span></span>
                                    {{ $a['tag'] }}
                                </span>
                            </div>

                            <h3 class="mt-5 text-xl font-semibold tracking-tight">{{ $a['name'] }}</h3>
                            <p class="mt-2 text-sm text-neutral-600 dark:text-neutral-400">{{ $a['summary'] }}</p>

                            {{-- Pipeline --}}
                            <ol class="mt-6 flex flex-wrap items-center gap-1.5 rounded-xl border border-dashed border-neutral-200 bg-neutral-50/70 p-3 text-[11px] font-medium dark:border-white/10 dark:bg-white/[0.02]" aria-label="How it works">
                                @foreach ($a['flow'] as $j => $step)
                                    <li class="flex items-center gap-1.5">
                                        <span class="rounded-md bg-white px-2 py-1 text-neutral-700 ring-1 ring-neutral-200 dark:bg-ink dark:text-neutral-300 dark:ring-white/10">{{ $step }}</span>
                                        @if (! $loop->last)<flux:icon.chevron-right variant="micro" class="size-3 text-brand-600 dark:text-brand-400" />@endif
                                    </li>
                                @endforeach
                            </ol>

                            <ul class="mt-6 space-y-2.5 text-sm">
                                @foreach ($a['features'] as $f)
                                    <li class="flex gap-2.5">
                                        <flux:icon.check-circle variant="mini" class="mt-px size-4.5 shrink-0 text-brand-600 dark:text-brand-400" />
                                        <span class="text-neutral-700 dark:text-neutral-300">{{ $f }}</span>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-auto flex flex-wrap gap-1.5 pt-6">
                                @foreach ($a['tech'] as $t)
                                    <flux:badge size="sm" class="rounded-full! bg-brand-500/12! text-brand-800! dark:text-brand-200!">{{ $t }}</flux:badge>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============ PROCESS (Flux Pro Timeline) ============ --}}
        <section id="process" class="py-20 sm:py-28">
            <div class="mx-auto grid max-w-7xl gap-16 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
                <div data-reveal class="lg:sticky lg:top-28 lg:self-start">
                    <flux:badge size="sm" class="rounded-full! bg-brand-500/15! text-brand-800! dark:text-brand-300!">How we work</flux:badge>
                    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-balance sm:text-5xl">No discovery theatre. <span class="font-display font-normal italic text-brand-700 dark:text-brand-400">Just delivery.</span></h2>
                    <p class="mt-4 max-w-lg text-neutral-600 dark:text-neutral-400">Login, roles, notifications, documents and reporting are already built and proven in production. Your budget goes into the parts that are unique to you.</p>

                    <div class="mt-10 grid gap-3 sm:grid-cols-2">
                        @foreach ([
                            ['lock-closed', 'Two-factor login for administrators'],
                            ['globe-alt', 'HTTPS enforced, database kept private'],
                            ['beaker', 'Staging environment, never test on live data'],
                            ['document-text', 'Documentation, training and handover'],
                        ] as [$icon, $text])
                            <div class="flex items-center gap-3 rounded-xl border border-neutral-200 p-3 text-sm dark:border-white/10">
                                <flux:icon :icon="$icon" variant="mini" class="shrink-0 text-brand-700 dark:text-brand-400" />
                                {{ $text }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div data-reveal style="--delay:120ms">
                    <flux:timeline size="lg" align="start">
                        @foreach ($process as $i => $step)
                            <flux:timeline.item status="{{ $i < 4 ? 'complete' : 'current' }}">
                                <flux:timeline.indicator>
                                    <flux:icon :icon="$step['icon']" variant="micro" />
                                </flux:timeline.indicator>
                                <flux:timeline.content class="pb-10">
                                    <div class="text-xs font-medium tracking-wider text-brand-700 uppercase dark:text-brand-400">Step {{ $i + 1 }}</div>
                                    <flux:heading size="lg" class="mt-1">{{ $step['title'] }}</flux:heading>
                                    <flux:text class="mt-2">{{ $step['text'] }}</flux:text>
                                </flux:timeline.content>
                            </flux:timeline.item>
                        @endforeach
                    </flux:timeline>
                </div>
            </div>
        </section>

        {{-- ============ MODERNISE (comparison) ============ --}}
        <section class="relative overflow-hidden bg-ink py-20 text-white sm:py-28">
            <div class="bg-grid mask-radial absolute inset-0 text-white opacity-60"></div>
            <div class="absolute -top-32 left-1/2 h-96 w-[50rem] -translate-x-1/2 rounded-full bg-brand-500/20 blur-3xl"></div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div data-reveal class="mx-auto max-w-2xl text-center">
                    <span class="inline-flex rounded-full border border-white/15 bg-white/5 px-3 py-1 text-xs font-medium text-brand-300">Legacy modernisation</span>
                    <h2 class="mt-4 text-3xl font-semibold tracking-tight text-balance sm:text-5xl">Still running on software <span class="font-display font-normal italic text-gradient">nobody patches?</span></h2>
                    <p class="mt-4 text-neutral-400">We replace ageing systems with supported, secure ones, and move your data across without stopping daily operations.</p>
                </div>

                <div class="mt-14 grid gap-3">
                    <div class="hidden grid-cols-[12rem_1fr_1fr] gap-4 px-6 text-xs font-medium tracking-wider text-neutral-500 uppercase md:grid">
                        <span>Area</span><span>Typical legacy system</span><span class="text-brand-300">What we deliver</span>
                    </div>
                    @foreach ($modernise as $i => [$area, $before, $after])
                        <div data-reveal style="--delay:{{ $i * 60 }}ms" class="spotlight-card grid gap-2 rounded-xl border border-white/10 bg-white/[0.03] px-6 py-4 md:grid-cols-[12rem_1fr_1fr] md:items-center md:gap-4">
                            <span class="font-semibold">{{ $area }}</span>
                            <span class="flex items-center gap-2 text-sm text-neutral-400"><flux:icon.x-circle variant="mini" class="shrink-0 text-rose-400/80" />{{ $before }}</span>
                            <span class="flex items-center gap-2 text-sm text-neutral-200"><flux:icon.check-circle variant="mini" class="shrink-0 text-brand-400" />{{ $after }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- ============ FAQ (Flux Pro Accordion) ============ --}}
        <section id="faq" class="py-20 sm:py-28">
            <div class="mx-auto grid max-w-7xl gap-12 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
                <div data-reveal>
                    <flux:badge size="sm" class="rounded-full! bg-brand-500/15! text-brand-800! dark:text-brand-300!">FAQ</flux:badge>
                    <h2 class="mt-4 text-3xl font-semibold tracking-tight sm:text-4xl">Questions, <span class="font-display font-normal italic text-brand-700 dark:text-brand-400">answered.</span></h2>
                    <p class="mt-4 text-neutral-600 dark:text-neutral-400">Something else on your mind? <a href="mailto:{{ $site['email'] }}" class="font-medium text-brand-800 underline decoration-brand-500/40 underline-offset-4 hover:decoration-brand-500 dark:text-brand-300">E-mail us</a> and we will reply within one business day.</p>
                </div>
                <div data-reveal style="--delay:100ms" class="lg:col-span-2">
                    <flux:accordion transition exclusive>
                        @foreach ($faqs as $i => $faq)
                            <flux:accordion.item :expanded="$i === 0" class="border-b border-neutral-200 py-2 dark:border-white/10">
                                <flux:accordion.heading class="text-base!">{{ $faq['q'] }}</flux:accordion.heading>
                                <flux:accordion.content>
                                    <p class="pb-2 text-neutral-600 dark:text-neutral-400">{{ $faq['a'] }}</p>
                                </flux:accordion.content>
                            </flux:accordion.item>
                        @endforeach
                    </flux:accordion>
                </div>
            </div>
        </section>

        {{-- ============ CONTACT ============ --}}
        <section id="contact" class="relative overflow-hidden pt-8 pb-24 sm:pb-32">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="noise relative isolate overflow-hidden rounded-3xl bg-gradient-to-br from-charcoal via-ink to-ink p-6 text-white sm:p-12 lg:p-16">
                    <div class="bg-grid mask-radial absolute inset-0 -z-10 text-white opacity-50"></div>
                    <div class="absolute -top-24 -right-24 -z-10 size-96 rounded-full bg-brand-500/25 blur-3xl"></div>
                    <div class="absolute -bottom-32 -left-20 -z-10 size-80 rounded-full bg-white/5 blur-3xl"></div>

                    <div class="grid gap-12 lg:grid-cols-5">
                        <div data-reveal class="lg:col-span-2">
                            <h2 class="text-3xl font-semibold tracking-tight text-balance sm:text-5xl">Let's build the system <span class="font-display font-normal italic text-gradient">your team deserves.</span></h2>
                            <p class="mt-5 text-neutral-300">Tell us what you want to digitise. We will reply within one business day with questions, an approach and next steps.</p>

                            <div class="mt-10 space-y-3">
                                <a href="mailto:{{ $site['email'] }}" class="group flex items-center gap-4 rounded-xl border border-white/10 bg-white/5 p-4 transition hover:border-brand-400/50 hover:bg-white/10">
                                    <span class="grid size-10 place-items-center rounded-lg bg-brand-500/20 text-brand-300"><flux:icon.envelope variant="mini" /></span>
                                    <span class="min-w-0"><span class="block text-xs text-neutral-400">E-mail</span><span class="block truncate font-medium">{{ $site['email'] }}</span></span>
                                    <flux:icon.arrow-up-right variant="micro" class="ms-auto text-neutral-500 transition group-hover:text-brand-300" />
                                </a>
                                <a href="https://wa.me/{{ $site['whatsapp'] }}" target="_blank" rel="noopener" class="group flex items-center gap-4 rounded-xl border border-white/10 bg-white/5 p-4 transition hover:border-brand-400/50 hover:bg-white/10">
                                    <span class="grid size-10 place-items-center rounded-lg bg-brand-500/20 text-brand-300"><flux:icon.chat-bubble-left-right variant="mini" /></span>
                                    <span><span class="block text-xs text-neutral-400">Phone / WhatsApp</span><span class="block font-medium">{{ $site['phone'] }}</span></span>
                                    <flux:icon.arrow-up-right variant="micro" class="ms-auto text-neutral-500 transition group-hover:text-brand-300" />
                                </a>
                                <div class="flex items-center gap-4 rounded-xl border border-white/10 bg-white/5 p-4">
                                    <span class="grid size-10 place-items-center rounded-lg bg-brand-500/20 text-brand-300"><flux:icon.map-pin variant="mini" /></span>
                                    <span><span class="block text-xs text-neutral-400">Based in</span><span class="block font-medium">{{ $site['location'] }}</span></span>
                                </div>
                            </div>
                        </div>

                        <div data-reveal style="--delay:120ms" class="relative rounded-2xl bg-white p-6 text-neutral-900 shadow-2xl sm:p-8 lg:col-span-3 dark:bg-neutral-900 dark:text-white">
                            <div class="border-beam" style="--beam-size: 160px; --beam-duration: 10s"></div>
                            <flux:heading size="lg">Start a project</flux:heading>
                            <flux:text class="mt-1 mb-6">Fields marked optional can be skipped.</flux:text>
                            <livewire:contact-form />
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- ============ FOOTER (21st.dev Dithered Footer) ============ --}}
    <x-landing.dithered-footer :site="$site" :nav="$nav" />
</x-layouts.landing>
