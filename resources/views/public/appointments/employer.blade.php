@extends('layouts.public')

@section('title', 'Employer / Client Consultation - Coyzon')

@section('content')
    <div class="bg-gray-50 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <a href="{{ route('public.appointments.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-bold flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back
                </a>
            </div>

            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
                <div class="bg-gradient-to-br from-emerald-950 to-emerald-900 px-8 py-10 relative overflow-hidden">
                    <!-- Decorative element -->
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 h-40 w-40 bg-green-500/20 rounded-full blur-3xl"></div>

                    <div class="relative z-10">
                        <h1 class="text-3xl font-black text-white uppercase tracking-tight mb-4">
                            Business Consultation
                        </h1>
                        <div class="space-y-4">
                            <p class="text-emerald-100 text-lg font-bold leading-tight">
                                You’re just one step away from a professional business consultation.
                            </p>
                            <p class="text-emerald-50/70 text-sm leading-relaxed max-w-2xl">
                                Please complete the form below to help us understand your hiring needs, staffing goals, and
                                business requirements. This allows our team to prepare a focused and results-driven
                                discussion.
                            </p>
                            <div class="text-emerald-400 text-xs font-bold uppercase tracking-wider pt-2">
                                All information shared is handled with professionalism and confidentiality.
                            </div>
                        </div>
                    </div>
                </div>

                <form id="consultationForm" action="{{ route('public.appointments.storeEmployer') }}" method="POST"
                    class="p-8 space-y-6">
                    @csrf

                    <!-- Step 1: Company Details -->
                    <div id="step1" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" name="name" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input type="text" name="company_name" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" name="email" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" name="phone" required
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <input type="text" name="country" required
                                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Job Title</label>
                                <input type="text" name="worker_type" required
                                    placeholder="e.g. Construction, Hospitality..."
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Number of Workers</label>
                                <input type="number" name="worker_count" required min="1"
                                    class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea name="message" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-green-500 focus:ring-green-500 shadow-sm p-3 border"></textarea>
                        </div>

                        <div class="pt-4">
                            <button type="button" onclick="nextStep()"
                                class="w-full flex justify-center py-4 px-4 border border-transparent rounded-xl shadow-sm text-lg font-bold text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                                Next
                            </button>
                            <div class="mt-4 px-1">
                                <p class="text-xs text-gray-500 leading-relaxed italic">
                                    Our team will review your request and confirm the appointment via email or phone.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Calendar -->
                    <div id="step2" class="hidden">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xl font-bold text-gray-900">Select Date & Time</h3>
                                <div class="flex items-center gap-2">
                                    <span class="w-3 h-3 bg-green-500 rounded-full"></span>
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Available
                                        Slots</span>
                                </div>
                            </div>

                            <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden min-h-[500px]">
                                <div id="bookingCalendar" class="p-2"></div>
                            </div>

                            <div id="selectionPreview"
                                class="hidden bg-green-50 border border-green-100 p-4 rounded-xl flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-green-700 uppercase tracking-wider">Your Selection
                                        </p>
                                        <p id="selectedDateTimeText" class="text-sm font-bold text-green-900"></p>
                                    </div>
                                </div>
                                <button type="button" onclick="clearSelection()"
                                    class="text-xs font-bold text-green-700 hover:text-green-900">
                                    Change
                                </button>
                            </div>

                            <input type="hidden" name="requested_date" id="requested_date_hidden" required>
                            <input type="hidden" name="requested_time" id="requested_time_hidden" required>

                            <div class="flex gap-4 pt-4">
                                <button type="button" onclick="prevStep()"
                                    class="flex-1 py-4 border border-gray-300 rounded-xl font-bold text-gray-700 hover:bg-gray-50 transition-all">
                                    Back
                                </button>
                                <button type="submit" id="submitBtn" disabled
                                    class="flex-[2] py-4 bg-green-600 opacity-50 cursor-not-allowed text-white font-bold rounded-xl shadow-sm text-lg transition-all">
                                    Confirm & Book
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
        <style>
            .fc {
                --fc-border-color: #f1f5f9;
                --fc-today-bg-color: #f0fdf4;
            }

            .fc-toolbar-title {
                font-size: 1.125rem !important;
                font-weight: 800 !important;
                color: #1e293b !important;
            }

            .fc-button {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                color: #475569 !important;
                font-weight: 700 !important;
                font-size: 0.875rem !important;
                border-radius: 8px !important;
            }

            .fc-button-active {
                background: #16a34a !important;
                color: white !important;
                border-color: #16a34a !important;
            }

            .fc-daygrid-day-number {
                font-weight: 600 !important;
                color: #475569 !important;
                padding: 10px !important;
                text-decoration: none !important;
            }

            .fc-col-header-cell-cushion {
                font-weight: 700 !important;
                color: #94a3b8 !important;
                text-transform: uppercase !important;
                font-size: 0.75rem !important;
                padding: 10px 0 !important;
                text-decoration: none !important;
            }

            .selected-date {
                background-color: #16a34a !important;
                color: white !important;
                border-radius: 8px;
            }

            .fc-timegrid-slot {
                height: 3em !important;
            }
        </style>
        <script>
            let calendar;
            function initCalendar() {
                const calendarEl = document.getElementById('bookingCalendar');
                if (!calendarEl || calendar) return;

                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: { left: 'prev,next', center: 'title', right: 'dayGridMonth,timeGridDay' },
                    selectable: true,
                    validRange: { start: new Date().toISOString().split('T')[0] },
                    allDaySlot: false,
                    slotMinTime: '08:00:00',
                    slotMaxTime: '18:00:00',
                    select: function (info) {
                        const date = info.startStr.split('T')[0];
                        const time = info.startStr.split('T')[1] ? info.startStr.split('T')[1].substring(0, 5) : '10:00';

                        document.getElementById('requested_date_hidden').value = date;
                        document.getElementById('requested_time_hidden').value = time;

                        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                        const formattedDate = new Date(date).toLocaleDateString(undefined, options);
                        document.getElementById('selectedDateTimeText').textContent = `${formattedDate} at ${time}`;

                        document.getElementById('selectionPreview').classList.remove('hidden');
                        const btn = document.getElementById('submitBtn');
                        btn.disabled = false;
                        btn.classList.remove('opacity-50', 'cursor-not-allowed');

                        if (info.view.type === 'dayGridMonth') {
                            calendar.changeView('timeGridDay', info.startStr);
                        }
                    }
                });
                calendar.render();
            }

            function clearSelection() {
                document.getElementById('requested_date_hidden').value = '';
                document.getElementById('requested_time_hidden').value = '';
                document.getElementById('selectionPreview').classList.add('hidden');
                const btn = document.getElementById('submitBtn');
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
                calendar.changeView('dayGridMonth');
            }

            function nextStep() {
                const step1 = document.getElementById('step1');
                const step2 = document.getElementById('step2');
                const requiredInputs = step1.querySelectorAll('[required]');
                let isValid = true;

                requiredInputs.forEach(input => {
                    if (!input.value) {
                        isValid = false;
                        input.classList.add('border-red-500');
                    } else {
                        input.classList.remove('border-red-500');
                    }
                });

                if (isValid) {
                    step1.classList.add('hidden');
                    step2.classList.remove('hidden');
                    setTimeout(() => {
                        initCalendar();
                        window.dispatchEvent(new Event('resize'));
                    }, 200);
                }
            }

            function prevStep() {
                document.getElementById('step1').classList.remove('hidden');
                document.getElementById('step2').classList.add('hidden');
            }
        </script>
    @endpush
@endsection