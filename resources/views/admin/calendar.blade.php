@extends('layouts.admin')

@section('title', 'Admin Calendar')

@section('content')
    <div class="h-[calc(100vh-120px)] flex flex-col space-y-4">
        <!-- Calendar Header -->
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Schedule Overview</h2>
                <p class="text-sm text-slate-500">Manage all interviews and consultations in one place</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-xl font-bold shadow-lg shadow-blue-500/20 hover:bg-blue-700 transition-all">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Add Event
                </button>
            </div>
        </div>

        <!-- FullCalendar Card -->
        <div class="flex-1 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col md:flex-row">
            <!-- Left Sidebar (Mini Calendar & Filters) -->
            <div class="w-full md:w-64 border-r border-slate-100 p-6 space-y-8 hidden md:block">
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">My Calendars</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-blue-600 transition-colors">Interviews</span>
                            <span class="ml-auto w-2 h-2 rounded-full bg-blue-500"></span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-green-600 focus:ring-green-500">
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-green-600 transition-colors">Consultations</span>
                            <span class="ml-auto w-2 h-2 rounded-full bg-green-500"></span>
                        </label>
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-yellow-600 focus:ring-yellow-500">
                            <span class="text-sm font-semibold text-slate-700 group-hover:text-yellow-600 transition-colors">Partnerships</span>
                            <span class="ml-auto w-2 h-2 rounded-full bg-yellow-500"></span>
                        </label>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-50">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-4">Upcoming</h3>
                    <div class="space-y-4">
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 italic text-xs text-slate-400 text-center">
                            No immediate events
                        </div>
                    </div>
                </div>
            </div>

            <!-- Calendar Container -->
            <div class="flex-1 p-6 flex flex-col">
                <div id="calendar" class="flex-1"></div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
    <style>
        /* Tooltip style */
        .fc-event {
            transition: all 0.2s ease;
            border: none !important;
            padding: 2px 4px !important;
            border-radius: 6px !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .fc-event:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            z-index: 10;
        }
        .fc-header-toolbar {
            margin-bottom: 2rem !important;
        }
        .fc-toolbar-title {
            font-size: 1.5rem !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            letter-spacing: -0.025em;
        }
        .fc-button {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            color: #475569 !important;
            font-weight: 700 !important;
            text-transform: capitalize !important;
            padding: 0.5rem 1rem !important;
            border-radius: 10px !important;
            transition: all 0.2s ease !important;
        }
        .fc-button-primary:not(:disabled):active, 
        .fc-button-primary:not(:disabled).fc-button-active {
            background-color: #2563eb !important;
            border-color: #2563eb !important;
            color: #ffffff !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2) !important;
        }
        .fc-button:hover {
            background: #f8fafc !important;
            border-color: #cbd5e1 !important;
        }
        .fc-today-button {
            border: 1px solid #e2e8f0 !important;
            color: #2563eb !important;
            margin-right: 1rem !important;
        }
        .fc-col-header-cell-cushion {
            text-decoration: none !important;
            font-weight: 700 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            font-size: 0.75rem !important;
            letter-spacing: 0.05em !important;
            padding: 1rem 0 !important;
        }
        .fc-daygrid-day-number {
             text-decoration: none !important;
             color: #1e293b !important;
             font-weight: 600 !important;
             padding: 8px 12px !important;
        }
        .fc-day-today {
            background-color: #f0f7ff !important;
        }
        .fc-day-today .fc-daygrid-day-number {
            background: #2563eb;
            color: white !important;
            border-radius: 9999px;
            width: 28px;
            height: 28px;
            padding: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 6px auto !important;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                themeSystem: 'standard',
                height: '100%',
                nowIndicator: true,
                dayMaxEvents: true,
                events: [
                    {
                        title: 'John Doe - Construction',
                        start: '2026-01-15T10:30:00',
                        end: '2026-01-15T11:15:00',
                        color: '#2563eb'
                    },
                    {
                        title: 'ABC Tech Consultation',
                        start: '2026-01-22T14:00:00',
                        end: '2026-01-22T14:45:00',
                        color: '#16a34a'
                    },
                    {
                        title: 'Global Partners Sync',
                        start: '2026-01-23',
                        color: '#ca8a04'
                    }
                ],
                eventClick: function(info) {
                    alert('Event: ' + info.event.title);
                }
            });
            calendar.render();
        });
    </script>
@endpush