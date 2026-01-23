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
                    <h1 class="text-2xl font-bold relative z-10">Payment Successful!</h1>
                    <p class="text-blue-100 mt-2 relative z-10">Now, please select a date and time to finalize your
                        appointment.</p>
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
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-slate-800">Pick Date & Time</h3>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></span>
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Available
                                    Slots</span>
                            </div>
                        </div>

                        <div class="bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-inner bg-gray-50/30">
                            <div id="bookingCalendar" class="p-4"></div>
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
                                    Confirm Appointment
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
            .fc {
                --fc-border-color: #f1f5f9;
                --fc-today-bg-color: #f0f9ff;
                font-family: inherit;
            }

            .fc-toolbar-title {
                font-size: 1.125rem !important;
                font-weight: 800 !important;
                color: #1e293b !important;
                text-transform: uppercase;
                letter-spacing: -0.025em;
            }

            .fc-button {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                color: #475569 !important;
                font-weight: 700 !important;
                font-size: 0.875rem !important;
                border-radius: 12px !important;
                padding: 8px 16px !important;
                transition: all 0.2s !important;
            }

            .fc-button:hover {
                background: #f8fafc !important;
                border-color: #cbd5e1 !important;
            }

            .fc-button-active {
                background: #2563eb !important;
                color: white !important;
                border-color: #2563eb !important;
            }

            .fc-daygrid-day-number {
                font-weight: 700 !important;
                color: #64748b !important;
                padding: 12px !important;
                text-decoration: none !important;
                font-size: 0.875rem;
            }

            .fc-col-header-cell-cushion {
                font-weight: 800 !important;
                color: #94a3b8 !important;
                text-transform: uppercase !important;
                font-size: 0.7rem !important;
                padding: 12px 0 !important;
                text-decoration: none !important;
                letter-spacing: 0.05em;
            }

            .selected-date {
                background-color: #2563eb !important;
                color: white !important;
                border-radius: 12px;
            }

            .fc-timegrid-slot {
                height: 3.5rem !important;
                border-bottom: 1px dashed #f1f5f9 !important;
            }

            .fc-list-event-title {
                font-weight: 600 !important;
            }

            /* Mobile Responsive Optimizations */
            @media (max-width: 640px) {
                .fc-header-toolbar {
                    flex-direction: column;
                    gap: 1rem;
                    align-items: center;
                }

                .fc-toolbar-chunk {
                    display: flex;
                    justify-content: center;
                    width: 100%;
                }

                .fc-toolbar-title {
                    font-size: 1rem !important;
                }

                .fc-button {
                    padding: 6px 12px !important;
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
                    height: 'auto', // Adjusts height based on content
                    contentHeight: 'auto',
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
                    slotDuration: '00:30:00', // 30 min slots for finer selection
                    expandRows: true, // Make rows expand to fill height
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