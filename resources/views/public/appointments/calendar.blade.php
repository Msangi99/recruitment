@extends('layouts.public')

@section('title', 'Schedule Consultation - Coyzon')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
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
                                <p class="mt-1 text-sm text-slate-500">Choose a day, then pick a slot. Weekdays &amp;
                                    Saturday, 8:00–18:00.</p>
                            </div>
                            <div
                                class="inline-flex items-center gap-2 self-start rounded-full border border-slate-200/80 bg-white px-3 py-1.5 text-xs font-semibold text-slate-600 shadow-sm">
                                <span class="relative flex h-2 w-2">
                                    <span
                                        class="absolute inline-flex h-full w-full animate-ping rounded-full bg-blue-500/40 opacity-75"></span>
                                    <span class="relative inline-flex h-2 w-2 rounded-full bg-blue-600"></span>
                                </span>
                                Live availability
                            </div>
                        </div>

                        <div
                            class="relative overflow-hidden rounded-3xl border border-slate-200/90 bg-gradient-to-b from-slate-50 to-white shadow-[0_1px_0_rgba(15,23,42,0.04),0_18px_45px_-24px_rgba(15,23,42,0.18)]">
                            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white to-transparent opacity-90"></div>
                            <div id="bookingCalendar" class="booking-cal-root p-3 sm:p-5"></div>
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
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
        <style>
            /* Scoped FullCalendar — booking flow only */
            #bookingCalendar.fc {
                --booking-primary: #2563eb;
                --booking-primary-hover: #1d4ed8;
                --booking-soft: #eff6ff;
                --booking-soft-strong: #dbeafe;
                --fc-border-color: rgba(148, 163, 184, 0.35);
                --fc-today-bg-color: transparent;
                --fc-page-bg-color: transparent;
                --fc-neutral-bg-color: #f8fafc;
                font-family: inherit;
            }

            #bookingCalendar .fc-scrollgrid {
                border-radius: 1.25rem;
                overflow: hidden;
                border: 1px solid rgba(148, 163, 184, 0.25) !important;
                background: #fff;
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.9);
            }

            #bookingCalendar .fc-scrollgrid-section-header > td {
                border-bottom: 1px solid rgba(148, 163, 184, 0.2) !important;
                background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
            }

            #bookingCalendar .fc-col-header-cell {
                padding: 0.5rem 0;
                border-color: rgba(148, 163, 184, 0.2) !important;
            }

            #bookingCalendar .fc-col-header-cell-cushion {
                font-weight: 600 !important;
                color: #64748b !important;
                font-size: 0.6875rem !important;
                letter-spacing: 0.08em;
                text-transform: uppercase !important;
                text-decoration: none !important;
                padding: 0.5rem 0 !important;
            }

            #bookingCalendar .fc-daygrid-day {
                min-height: 3.25rem;
                border-color: rgba(241, 245, 249, 0.9) !important;
            }

            @media (min-width: 640px) {
                #bookingCalendar .fc-daygrid-day {
                    min-height: 3.75rem;
                }
            }

            #bookingCalendar .fc-daygrid-day-frame {
                padding: 0.35rem 0.25rem 0.5rem;
            }

            #bookingCalendar .fc-daygrid-day-top {
                justify-content: center;
            }

            #bookingCalendar .fc-daygrid-day-number {
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
                width: 2.125rem;
                height: 2.125rem;
                margin: 0 auto !important;
                padding: 0 !important;
                border-radius: 9999px;
                font-weight: 600 !important;
                font-size: 0.8125rem !important;
                color: #334155 !important;
                text-decoration: none !important;
                transition: background 0.15s ease, color 0.15s ease, box-shadow 0.15s ease, transform 0.15s ease;
            }

            @media (min-width: 640px) {
                #bookingCalendar .fc-daygrid-day-number {
                    width: 2.375rem;
                    height: 2.375rem;
                    font-size: 0.875rem !important;
                }
            }

            #bookingCalendar .fc-daygrid-day:not(.fc-day-other):not(.fc-day-past) .fc-daygrid-day-number:hover {
                background: var(--booking-soft);
                color: var(--booking-primary) !important;
                transform: scale(1.04);
            }

            #bookingCalendar .fc-day-other {
                background: #f8fafc !important;
            }

            #bookingCalendar .fc-day-other .fc-daygrid-day-number {
                color: #94a3b8 !important;
                font-weight: 500 !important;
            }

            #bookingCalendar .fc-day-past .fc-daygrid-day-number {
                color: #cbd5e1 !important;
                pointer-events: none;
            }

            #bookingCalendar .fc-day-today:not(.fc-day-other) .fc-daygrid-day-number {
                box-shadow: 0 0 0 2px var(--booking-primary), 0 4px 14px -4px rgba(37, 99, 235, 0.45);
                color: var(--booking-primary) !important;
                background: #fff;
            }

            #bookingCalendar .fc-daygrid-day.fc-day-today {
                background: rgba(239, 246, 255, 0.55) !important;
            }

            #bookingCalendar .fc-highlight {
                background: rgba(37, 99, 235, 0.12) !important;
                border-radius: 0.5rem;
            }

            #bookingCalendar .fc-timegrid-slot {
                height: 3.25rem !important;
                border-color: rgba(241, 245, 249, 0.95) !important;
            }

            #bookingCalendar .fc-timegrid-slot-label {
                font-size: 0.75rem;
                font-weight: 500;
                color: #64748b;
            }

            #bookingCalendar .fc-timegrid-axis-cushion {
                color: #94a3b8;
                font-weight: 600;
                font-size: 0.6875rem;
            }

            #bookingCalendar .fc-timegrid-col.fc-day-today {
                background: rgba(239, 246, 255, 0.35) !important;
            }

            #bookingCalendar .fc-timegrid-now-indicator-line {
                border-color: var(--booking-primary) !important;
                border-width: 2px 0 0 !important;
                opacity: 0.9;
            }

            #bookingCalendar .fc-timegrid-now-indicator-arrow {
                border-color: var(--booking-primary) !important;
            }

            /* Toolbar */
            #bookingCalendar .fc-header-toolbar {
                margin-bottom: 1rem !important;
                padding: 0.25rem;
                gap: 0.75rem;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                border-radius: 1rem;
                background: rgba(248, 250, 252, 0.95);
                border: 1px solid rgba(226, 232, 240, 0.9);
            }

            #bookingCalendar .fc-toolbar-title {
                font-size: 1.0625rem !important;
                font-weight: 700 !important;
                color: #0f172a !important;
                text-transform: none !important;
                letter-spacing: -0.02em;
            }

            #bookingCalendar .fc-button {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                color: #475569 !important;
                font-weight: 600 !important;
                font-size: 0.8125rem !important;
                border-radius: 0.75rem !important;
                padding: 0.5rem 0.875rem !important;
                line-height: 1.25 !important;
                box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
                transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease, box-shadow 0.15s ease !important;
            }

            #bookingCalendar .fc-button:hover {
                background: #f8fafc !important;
                border-color: #cbd5e1 !important;
                color: #0f172a !important;
            }

            #bookingCalendar .fc-button:focus {
                box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.25) !important;
            }

            #bookingCalendar .fc-button-primary:not(:disabled):active,
            #bookingCalendar .fc-button-primary:not(:disabled).fc-button-active {
                background: var(--booking-primary) !important;
                border-color: var(--booking-primary) !important;
                color: #fff !important;
                box-shadow: 0 4px 14px -4px rgba(37, 99, 235, 0.55);
            }

            #bookingCalendar .fc-button-primary:not(:disabled):not(.fc-button-active):hover {
                background: #f1f5f9 !important;
                border-color: #cbd5e1 !important;
                color: #0f172a !important;
                box-shadow: 0 1px 2px rgba(15, 23, 42, 0.06);
            }

            #bookingCalendar .fc-button-primary.fc-button-active:hover {
                background: var(--booking-primary-hover) !important;
                border-color: var(--booking-primary-hover) !important;
                color: #fff !important;
            }

            #bookingCalendar .fc-prev-button,
            #bookingCalendar .fc-next-button {
                border-radius: 9999px !important;
                width: 2.5rem;
                height: 2.5rem;
                padding: 0 !important;
                display: inline-flex !important;
                align-items: center;
                justify-content: center;
            }

            #bookingCalendar .fc-toolbar-chunk:last-child {
                display: inline-flex;
                padding: 0.2rem;
                border-radius: 9999px;
                background: #fff;
                border: 1px solid #e2e8f0;
                gap: 0.15rem;
                box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
            }

            #bookingCalendar .fc-toolbar-chunk:last-child .fc-button {
                border-radius: 9999px !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0.45rem 1rem !important;
                font-size: 0.75rem !important;
                text-transform: capitalize;
            }

            #bookingCalendar .fc-toolbar-chunk:last-child .fc-button.fc-button-active {
                background: var(--booking-soft) !important;
                color: var(--booking-primary) !important;
            }

            #bookingCalendar .fc-toolbar-chunk:last-child .fc-button:not(.fc-button-active) {
                background: transparent !important;
                color: #64748b !important;
            }

            #bookingCalendar .fc-toolbar-chunk:last-child .fc-button:not(.fc-button-active):hover {
                background: #f8fafc !important;
                color: #0f172a !important;
            }

            #bookingCalendar .fc-list-event-title {
                font-weight: 600 !important;
            }

            @media (max-width: 640px) {
                #bookingCalendar .fc-header-toolbar {
                    flex-direction: column;
                    align-items: stretch;
                }

                #bookingCalendar .fc-toolbar-chunk {
                    display: flex;
                    justify-content: center;
                    width: 100%;
                }

                /* Center (month title) first, then nav, then view toggle */
                #bookingCalendar .fc-toolbar-chunk:nth-child(2) {
                    order: -1;
                }

                #bookingCalendar .fc-toolbar-title {
                    font-size: 1rem !important;
                    text-align: center;
                    width: 100%;
                }

                #bookingCalendar .fc-toolbar-chunk:last-child {
                    justify-content: center;
                }

                #bookingCalendar .fc-button {
                    padding: 0.45rem 0.75rem !important;
                    font-size: 0.75rem !important;
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
                    titleFormat: { year: 'numeric', month: 'long' },
                    dayHeaderFormat: { weekday: 'short' },
                    slotLabelFormat: { hour: 'numeric', minute: '2-digit', meridiem: 'short' },
                    scrollTime: '09:00:00',
                    nowIndicator: true,
                    headerToolbar: {
                        left: 'prev,next',
                        center: 'title',
                        right: 'dayGridMonth,timeGridDay'
                    },
                    buttonText: {
                        today: 'Today',
                        month: 'Month',
                        day: 'Day',
                    },
                    selectable: true,
                    validRange: { start: new Date().toISOString().split('T')[0] },
                    allDaySlot: false,
                    slotMinTime: '08:00:00',
                    slotMaxTime: '18:00:00',
                    slotDuration: '00:30:00',
                    expandRows: true,
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