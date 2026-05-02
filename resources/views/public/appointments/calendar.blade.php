@extends('layouts.public')

@section('title', 'Schedule Consultation - Coyzon')

@section('content')
    <div class="bg-slate-100/80 min-h-screen py-8 sm:py-10">
        <div class="max-w-md mx-auto px-4 sm:px-5">
            <div
                class="bg-white rounded-2xl shadow-lg shadow-slate-200/60 ring-1 ring-slate-200/80 overflow-hidden">
                <div
                    class="relative px-5 py-4 sm:px-6 sm:py-5 bg-gradient-to-br from-blue-600 via-blue-600 to-indigo-700 text-white">
                    <div class="absolute inset-0 opacity-30 pointer-events-none"
                        style="background-image: radial-gradient(circle at 20% 0%, rgba(255,255,255,0.25), transparent 45%);">
                    </div>
                    <div class="relative flex items-start gap-3">
                        <div
                            class="flex-shrink-0 w-10 h-10 rounded-xl bg-white/15 backdrop-blur-sm flex items-center justify-center ring-1 ring-white/20">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0 text-left">
                            <h1 class="text-lg font-semibold tracking-tight leading-snug">Select date & time</h1>
                            <p class="text-xs text-blue-100/95 mt-1 leading-relaxed">Pick a slot, then continue to payment.
                            </p>
                        </div>
                    </div>
                </div>

                @if(session('info'))
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mx-4 mt-4 sm:mx-5 sm:mt-5 rounded-r-lg">
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

                <div class="p-4 sm:p-5 space-y-5">
                    @if(session('error'))
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-xl shadow-sm">
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

                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <h3 class="text-sm font-semibold text-slate-800 tracking-tight">Calendar</h3>
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2 py-0.5 text-[10px] font-medium text-slate-500 ring-1 ring-slate-200/80">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                Open days
                            </span>
                        </div>

                        <div
                            class="rounded-xl bg-slate-50/90 ring-1 ring-slate-200/70 p-2 sm:p-2.5 booking-calendar-shell">
                            <div id="bookingCalendar" class="booking-calendar-fc"></div>
                        </div>

                        <div id="selectionPreview"
                            class="hidden flex-col sm:flex-row sm:items-center justify-between gap-3 bg-blue-50/90 border border-blue-100/80 p-3 rounded-xl">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-md shadow-blue-500/25">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[10px] font-semibold text-blue-600 uppercase tracking-wide">Selected</p>
                                    <p id="selectedDateTimeText" class="text-sm font-semibold text-slate-900 leading-snug">
                                    </p>
                                </div>
                            </div>
                            <button type="button" onclick="clearSelection()"
                                class="shrink-0 px-3 py-1.5 text-xs font-semibold text-blue-700 hover:bg-blue-100/80 rounded-lg transition-colors">
                                Change
                            </button>
                        </div>

                        <form action="{{ route('public.appointments.storeSchedule', ['id' => $request->id]) }}"
                            method="POST">
                            @csrf
                            <input type="hidden" name="scheduled_date" id="requested_date_hidden" required>
                            <input type="hidden" name="scheduled_time" id="requested_time_hidden" required>

                            <div class="pt-3">
                                <button type="submit" id="submitBtn" disabled
                                    class="w-full py-3.5 bg-blue-600 opacity-50 cursor-not-allowed text-white font-semibold rounded-xl shadow-md shadow-blue-600/20 text-sm transition-all hover:bg-blue-700">
                                    Proceed to payment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
        <style>
            .booking-calendar-shell {
                --cal-accent: #2563eb;
                --cal-accent-soft: #dbeafe;
                --cal-muted: #94a3b8;
                --cal-surface: #f8fafc;
            }

            .booking-calendar-fc .fc {
                --fc-border-color: transparent;
                --fc-neutral-bg-color: transparent;
                --fc-page-bg-color: transparent;
                --fc-today-bg-color: rgba(37, 99, 235, 0.06);
                font-family: ui-sans-serif, system-ui, sans-serif;
                font-size: 0.8125rem;
            }

            .booking-calendar-fc .fc-scrollgrid,
            .booking-calendar-fc .fc-scrollgrid-section,
            .booking-calendar-fc .fc-scrollgrid-sync-table {
                border-color: transparent !important;
            }

            .booking-calendar-fc .fc-theme-standard td,
            .booking-calendar-fc .fc-theme-standard th {
                border-color: transparent !important;
            }

            .booking-calendar-fc .fc-col-header-cell {
                padding: 0.125rem 0 0.375rem !important;
                background: transparent !important;
            }

            .booking-calendar-fc .fc-col-header-cell-cushion {
                font-weight: 600 !important;
                color: var(--cal-muted) !important;
                font-size: 0.65rem !important;
                padding: 0 !important;
                text-decoration: none !important;
                letter-spacing: 0.02em;
            }

            .booking-calendar-fc .fc-daygrid-day {
                background: transparent !important;
            }

            .booking-calendar-fc .fc-daygrid-day-frame {
                min-height: 2rem !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
            }

            .booking-calendar-fc .fc-daygrid-day-top {
                flex-direction: row !important;
                justify-content: center !important;
            }

            .booking-calendar-fc .fc-daygrid-day-number {
                font-weight: 600 !important;
                color: #475569 !important;
                padding: 0 !important;
                margin: 0 !important;
                width: 1.75rem !important;
                height: 1.75rem !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                border-radius: 9999px !important;
                font-size: 0.75rem !important;
                text-decoration: none !important;
                transition: background 0.15s, color 0.15s;
            }

            .booking-calendar-fc .fc-daygrid-day:not(.fc-day-other):not(.fc-day-disabled) .fc-daygrid-day-number:hover {
                background: #e2e8f0 !important;
                color: #0f172a !important;
            }

            .booking-calendar-fc .fc-day-other .fc-daygrid-day-number {
                color: #cbd5e1 !important;
                font-weight: 500 !important;
            }

            .booking-calendar-fc .fc-day-disabled .fc-daygrid-day-number,
            .booking-calendar-fc .fc-day-past:not(.fc-day-other) .fc-daygrid-day-number {
                opacity: 0.35 !important;
            }

            .booking-calendar-fc .fc-day-today:not(.fc-day-other) .fc-daygrid-day-number {
                box-shadow: inset 0 0 0 1.5px var(--cal-accent) !important;
                color: var(--cal-accent) !important;
                background: rgba(37, 99, 235, 0.06) !important;
            }

            .booking-calendar-fc .fc-highlight {
                background: var(--cal-accent-soft) !important;
            }

            .booking-calendar-fc .fc-header-toolbar {
                margin-bottom: 0.5rem !important;
                padding: 0 0.125rem !important;
                gap: 0.5rem !important;
            }

            .booking-calendar-fc .fc-toolbar-title {
                font-size: 0.9375rem !important;
                font-weight: 600 !important;
                color: #0f172a !important;
                text-transform: none !important;
                letter-spacing: -0.02em !important;
            }

            .booking-calendar-fc .fc-button {
                background: #fff !important;
                border: 1px solid #e2e8f0 !important;
                color: #64748b !important;
                font-weight: 600 !important;
                font-size: 0.75rem !important;
                border-radius: 0.5rem !important;
                padding: 0.35rem 0.55rem !important;
                line-height: 1.2 !important;
                transition: background 0.15s, border-color 0.15s, color 0.15s !important;
                box-shadow: 0 1px 0 rgba(15, 23, 42, 0.04) !important;
            }

            .booking-calendar-fc .fc-button:hover {
                background: #f8fafc !important;
                border-color: #cbd5e1 !important;
                color: #334155 !important;
            }

            .booking-calendar-fc .fc-button-primary:not(:disabled):active,
            .booking-calendar-fc .fc-button-primary:not(:disabled).fc-button-active {
                background: var(--cal-accent) !important;
                color: #fff !important;
                border-color: var(--cal-accent) !important;
            }

            .booking-calendar-fc .fc-button-group {
                border-radius: 0.5rem !important;
                overflow: hidden !important;
                box-shadow: 0 1px 0 rgba(15, 23, 42, 0.04) !important;
            }

            .booking-calendar-fc .fc-button-group > .fc-button {
                border-radius: 0 !important;
                margin-left: -1px !important;
            }

            .booking-calendar-fc .fc-button-group > .fc-button:first-child {
                border-radius: 0.5rem 0 0 0.5rem !important;
                margin-left: 0 !important;
            }

            .booking-calendar-fc .fc-button-group > .fc-button:last-child {
                border-radius: 0 0.5rem 0.5rem 0 !important;
            }

            .booking-calendar-fc .fc-prev-button,
            .booking-calendar-fc .fc-next-button {
                padding: 0.35rem 0.45rem !important;
            }

            .booking-calendar-fc .fc-timegrid-slot {
                height: 2.75rem !important;
                border-bottom: 1px solid #f1f5f9 !important;
            }

            .booking-calendar-fc .fc-timegrid-axis-cushion,
            .booking-calendar-fc .fc-timegrid-slot-label-cushion {
                font-size: 0.7rem !important;
                color: #94a3b8 !important;
            }

            .booking-calendar-fc .fc-list-event-title {
                font-weight: 600 !important;
            }

            @media (max-width: 640px) {
                .booking-calendar-fc .fc-header-toolbar {
                    flex-direction: column;
                    align-items: stretch;
                    gap: 0.625rem;
                }

                .booking-calendar-fc .fc-toolbar-chunk {
                    display: flex;
                    justify-content: center;
                    width: 100%;
                }

                .booking-calendar-fc .fc-toolbar-title {
                    font-size: 0.875rem !important;
                }
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const calendarEl = document.getElementById('bookingCalendar');
                const isMobile = window.innerWidth < 768;

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    height: 'auto',
                    contentHeight: 'auto',
                    fixedWeekCount: false,
                    showNonCurrentDates: true,
                    dayHeaderFormat: { weekday: 'short' },
                    titleFormat: { month: 'long', year: 'numeric' },
                    views: {
                        dayGridMonth: { buttonText: 'Month' },
                        timeGridDay: { buttonText: 'Day' },
                    },
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,timeGridDay'
                    },
                    selectable: true,
                    validRange: { start: new Date().toISOString().split('T')[0] },
                    allDaySlot: false,
                    slotMinTime: '08:00:00',
                    slotMaxTime: '18:00:00',
                    slotDuration: '00:30:00',
                    expandRows: false,
                    selectConstraint: {
                        daysOfWeek: [1, 2, 3, 4, 5, 6] // Mon-Sat
                    },
                    selectLongPressDelay: 100, // Better touch response
                    select: function (info) {
                        // If in month view, just switch to day view for that date
                        if (info.view.type === 'dayGridMonth') {
                            calendar.changeView('timeGridDay', info.startStr);
                            return;
                        }

                        // In time selection view
                        const date = info.startStr.split('T')[0];
                        const time = info.startStr.split('T')[1].substring(0, 5);

                        document.getElementById('requested_date_hidden').value = date;
                        document.getElementById('requested_time_hidden').value = time;

                        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                        const formattedDate = new Date(date).toLocaleDateString(undefined, options);

                        // Convert 24h to 12h for display
                        const [hours, minutes] = time.split(':');
                        const ampm = hours >= 12 ? 'PM' : 'AM';
                        const hours12 = hours % 12 || 12;
                        const formattedTime = `${hours12}:${minutes} ${ampm}`;

                        document.getElementById('selectedDateTimeText').textContent = `${formattedDate} at ${formattedTime}`;

                        document.getElementById('selectionPreview').classList.remove('hidden');
                        document.getElementById('selectionPreview').classList.add('flex');

                        // Scroll to preview on mobile
                        if (window.innerWidth < 768) {
                            document.getElementById('selectionPreview').scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }

                        const btn = document.getElementById('submitBtn');
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');
                    },
                    windowResize: function (view) {
                        if (window.innerWidth < 768) {
                            calendar.setOption('headerToolbar', {
                                left: 'prev,next',
                                center: 'title',
                                right: 'timeGridDay' // Simplify on mobile
                            });
                        } else {
                            calendar.setOption('headerToolbar', {
                                left: 'prev,next',
                                center: 'title',
                                right: 'dayGridMonth,timeGridDay'
                            });
                        }
                    }
                });

                // Initial mobile check
                if (isMobile) {
                    calendar.setOption('headerToolbar', {
                        left: 'prev,next',
                        center: 'title',
                        right: 'timeGridDay'
                    });
                }

                calendar.render();

                window.clearSelection = function () {
                    document.getElementById('requested_date_hidden').value = '';
                    document.getElementById('requested_time_hidden').value = '';
                    document.getElementById('selectionPreview').classList.add('hidden');
                    document.getElementById('selectionPreview').classList.remove('flex');
                    const btn = document.getElementById('submitBtn');
                    btn.disabled = true;
                    btn.classList.add('opacity-50', 'cursor-not-allowed');
                    calendar.changeView('dayGridMonth');
                }
            });
        </script>
    @endpush
@endsection