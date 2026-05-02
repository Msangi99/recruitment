@extends('layouts.public')

@section('title', 'Schedule Consultation - Coyzon')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@calendarjs/ce/dist/style.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Material+Icons" />
@endpush

@section('content')
    <div id="booking-schedule-page" class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100">
                <div class="bg-blue-600 px-8 py-8 text-center text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-8 -mr-8 h-32 w-32 rounded-full bg-white/10 blur-2xl"></div>
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold relative z-10">Select Date & Time</h1>
                    <p class="text-blue-100 mt-2 relative z-10">Choose a convenient slot for your consultation. Payment will
                        be required in the next step.</p>
                </div>

                @if(session('info'))
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mx-6 mt-6 rounded-r-xl">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-bold text-blue-800">Next Step</p>
                                <p class="text-sm text-blue-700">{{ session('info') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="p-8 space-y-8">
                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 p-6 rounded-r-2xl shadow-sm">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-bold text-red-800 mb-1">Payment Error</h3>
                                    <p class="text-sm text-red-700 font-semibold">{{ session('error') }}</p>
                                    @if(session('error_details'))
                                        <details class="mt-3">
                                            <summary class="text-xs font-bold text-red-600 cursor-pointer hover:text-red-800">Show
                                                technical details</summary>
                                            <div class="mt-2 p-3 bg-red-100/50 rounded-lg border border-red-200">
                                                <p class="text-xs text-red-700 font-mono break-all">{{ session('error_details') }}
                                                </p>
                                            </div>
                                        </details>
                                    @endif
                                    <div class="mt-4">
                                        <a href="{{ route('public.appointments.jobSeeker.form') }}"
                                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                                </path>
                                            </svg>
                                            Try Again
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(session('success'))
                        <div
                            class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-sm font-semibold">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-xl font-bold tracking-tight text-slate-900">Pick date &amp; time</h3>
                                <p class="mt-1 text-sm text-slate-500">Tap the field below to open the calendar. Monday–Saturday,
                                    8:00–18:00.</p>
                            </div>
                            <div
                                class="inline-flex items-center gap-2 self-start rounded-full border border-slate-200/80 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 shadow-sm">
                                <span class="relative flex h-2 w-2">
                                    <span
                                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-500/40 opacity-75"></span>
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-600"></span>
                                </span>
                                CalendarJS
                            </div>
                        </div>

                        <div
                            class="relative overflow-visible rounded-3xl border border-slate-200/90 bg-gradient-to-b from-slate-50 to-white p-4 shadow-[0_1px_0_rgba(15,23,42,0.04),0_18px_45px_-24px_rgba(15,23,42,0.18)] sm:p-6">
                            <p id="bookingTimeHint" class="mb-3 hidden text-sm font-medium text-amber-800"></p>
                            <div id="calendarBookingHost" class="booking-calendarjs-host relative z-20">
                                <label for="bookingDateInput" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">Consultation slot</label>
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-stretch">
                                    <input type="text" id="bookingDateInput" readonly autocomplete="off"
                                        placeholder="Tap to open calendar…"
                                        class="min-h-[3.25rem] w-full flex-1 cursor-pointer rounded-2xl border border-slate-200 bg-white px-4 py-3 text-base font-medium text-slate-900 shadow-sm outline-none ring-blue-500/0 transition hover:border-blue-300 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/15" />
                                    <button type="button" id="bookingOpenCalendarBtn"
                                        class="inline-flex shrink-0 items-center justify-center gap-2 rounded-2xl bg-blue-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-blue-500/25 transition hover:bg-blue-700">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        Open calendar
                                    </button>
                                </div>
                                <div id="calendarJsMount" class="calendarjs-mount"></div>
                            </div>
                        </div>

                        <div id="selectionPreview"
                            class="hidden bg-blue-50 border border-blue-100 p-6 rounded-2xl md:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-blue-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-blue-600 uppercase tracking-widest">Selected Slot
                                    </p>
                                    <p id="selectedDateTimeText" class="text-lg font-bold text-slate-900"></p>
                                </div>
                            </div>
                            <button type="button" onclick="clearSelection()"
                                class="px-4 py-2 text-xs font-bold text-blue-600 hover:bg-blue-100 rounded-lg transition-colors">
                                Change Time
                            </button>
                        </div>

                        <form action="{{ route('public.appointments.storeSchedule', ['id' => $request->id]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="scheduled_date" id="requested_date_hidden" required>
                            <input type="hidden" name="scheduled_time" id="requested_time_hidden" required>

                            <div class="pt-6">
                                <button type="submit" id="submitBtn" disabled
                                    class="w-full py-5 bg-blue-600 opacity-50 cursor-not-allowed text-white font-black rounded-2xl shadow-xl shadow-blue-500/20 text-xl transition-all hover:bg-blue-700">
                                    Proceed to Payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/lemonadejs/dist/lemonade.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@calendarjs/ce/dist/index.min.js"></script>
        <style>
            /*
               CalendarJS ships .lm-modal { position: fixed; left: 0; bottom: 0 } which pins the picker
               to the bottom-left. Override only within this booking flow.
            */
            #booking-schedule-page .lm-modal {
                position: fixed !important;
                left: 50% !important;
                top: 50% !important;
                right: auto !important;
                bottom: auto !important;
                width: min(22rem, calc(100vw - 1.5rem)) !important;
                min-width: min(22rem, calc(100vw - 1.5rem)) !important;
                min-height: unset !important;
                max-height: min(32rem, 90vh) !important;
                transform: translate(-50%, -50%) !important;
                margin: 0 !important;
                margin-left: 0 !important;
                margin-top: 0 !important;
                z-index: 9999 !important;
                box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.25);
                border-radius: 1rem;
                overflow: auto;
            }

            #booking-schedule-page .lm-modal .lm-modal-title {
                border-radius: 1rem 1rem 0 0;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const { Calendar } = calendarjs;

                const inputEl = document.getElementById('bookingDateInput');
                const mountEl = document.getElementById('calendarJsMount');
                const hintEl = document.getElementById('bookingTimeHint');
                let calInstance = null;
                let calendarOpenedOnce = false;

                function pad2(n) {
                    return String(n).padStart(2, '0');
                }

                function parseCalValue(val) {
                    if (!val || typeof val !== 'string') return null;
                    const normalized = val.trim().replace('T', ' ');
                    const m = normalized.match(/^(\d{4})-(\d{2})-(\d{2})(?:\s+(\d{2}):(\d{2})(?::(\d{2}))?)?/);
                    if (!m) return null;
                    const y = parseInt(m[1], 10);
                    const mo = parseInt(m[2], 10) - 1;
                    const da = parseInt(m[3], 10);
                    const hh = m[4] !== undefined ? parseInt(m[4], 10) : 9;
                    const mi = m[5] !== undefined ? parseInt(m[5], 10) : 0;
                    return new Date(Date.UTC(y, mo, da, hh, mi, 0));
                }

                function toCalUtcString(d) {
                    return (
                        d.getUTCFullYear() +
                        '-' +
                        pad2(d.getUTCMonth() + 1) +
                        '-' +
                        pad2(d.getUTCDate()) +
                        ' ' +
                        pad2(d.getUTCHours()) +
                        ':' +
                        pad2(d.getUTCMinutes()) +
                        ':00'
                    );
                }

                function clampToBusinessHours(d) {
                    let total = d.getUTCHours() * 60 + d.getUTCMinutes();
                    const open = 8 * 60;
                    const close = 18 * 60;
                    if (total < open) total = open;
                    if (total >= close) total = close - 30;
                    let step = Math.round((total - open) / 30) * 30 + open;
                    if (step >= close) step = close - 30;
                    const h = Math.floor(step / 60);
                    const min = step % 60;
                    return new Date(Date.UTC(d.getUTCFullYear(), d.getUTCMonth(), d.getUTCDate(), h, min, 0));
                }

                function formatSlotLabel(d) {
                    const local = new Date(d.getTime());
                    const dateStr = local.toLocaleDateString(undefined, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    const h = local.getHours();
                    const min = pad2(local.getMinutes());
                    const ampm = h >= 12 ? 'PM' : 'AM';
                    const h12 = h % 12 || 12;
                    return dateStr + ' at ' + h12 + ':' + min + ' ' + ampm;
                }

                function applyFromCalendar(instance) {
                    hintEl.classList.add('hidden');
                    hintEl.textContent = '';
                    const raw = instance && typeof instance.getValue === 'function' ? instance.getValue() : '';
                    const d = parseCalValue(raw);
                    if (!d) return;

                    let adjusted = clampToBusinessHours(d);
                    const orig = d.getTime();
                    if (adjusted.getTime() !== orig) {
                        instance.setValue(toCalUtcString(adjusted));
                        hintEl.textContent = 'Time adjusted to allowed hours (last slot 17:30, 30-minute steps).';
                        hintEl.classList.remove('hidden');
                    }

                    const local = new Date(adjusted.getTime());
                    const datePart =
                        local.getFullYear() + '-' + pad2(local.getMonth() + 1) + '-' + pad2(local.getDate());
                    const timePart = pad2(local.getHours()) + ':' + pad2(local.getMinutes());

                    document.getElementById('requested_date_hidden').value = datePart;
                    document.getElementById('requested_time_hidden').value = timePart;
                    document.getElementById('selectedDateTimeText').textContent = formatSlotLabel(adjusted);
                    document.getElementById('selectionPreview').classList.remove('hidden');
                    document.getElementById('selectionPreview').classList.add('flex');

                    const btn = document.getElementById('submitBtn');
                    btn.disabled = false;
                    btn.classList.remove('opacity-50', 'cursor-not-allowed');

                    if (window.innerWidth < 768) {
                        document.getElementById('selectionPreview').scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }

                const today = new Date();

                const calOpts = Calendar(mountEl, {
                    type: 'default',
                    input: inputEl,
                    time: true,
                    value: new Date(),
                    startingDay: 1,
                    footer: true,
                    validRange: function (day, m, year) {
                        const d = new Date(Date.UTC(year, m, day));
                        const utcToday = Date.UTC(today.getUTCFullYear(), today.getUTCMonth(), today.getUTCDate());
                        if (d.getTime() < utcToday) return true;
                        if (d.getUTCDay() === 0) return true;
                        return false;
                    },
                    onopen: function () {
                        calendarOpenedOnce = true;
                    },
                    onchange: function (instance) {
                        calInstance = instance;
                        if (!calendarOpenedOnce) return;
                        applyFromCalendar(instance);
                    },
                });

                requestAnimationFrame(function () {
                    if (calOpts && typeof calOpts.open === 'function') {
                        calInstance = calOpts;
                    }
                });

                document.getElementById('bookingOpenCalendarBtn').addEventListener('click', function () {
                    inputEl.focus();
                    if (calInstance && typeof calInstance.open === 'function' && calInstance.isClosed && calInstance.isClosed()) {
                        calInstance.open();
                    }
                });

                window.clearSelection = function () {
                    calendarOpenedOnce = false;
                    document.getElementById('requested_date_hidden').value = '';
                    document.getElementById('requested_time_hidden').value = '';
                    inputEl.value = '';
                    document.getElementById('selectionPreview').classList.add('hidden');
                    document.getElementById('selectionPreview').classList.remove('flex');
                    hintEl.classList.add('hidden');
                    hintEl.textContent = '';
                    const btn = document.getElementById('submitBtn');
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                    if (calInstance && typeof calInstance.setValue === 'function') {
                        calInstance.setValue(new Date());
                    }
                };
            });
        </script>
    @endpush
@endsection
