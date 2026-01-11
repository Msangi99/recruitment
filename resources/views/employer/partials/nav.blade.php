@section('page_label', 'Employer')
@section('sidebar')
    <x-admin-sidebar-item href="{{ route('employer.dashboard') }}" icon="layout-dashboard" label="Dashboard" :active="request()->routeIs('employer.dashboard')" />
    <x-admin-sidebar-item href="{{ route('employer.jobs.index') }}" icon="briefcase" label="My Jobs" :active="request()->routeIs('employer.jobs.*')" />
    <x-admin-sidebar-item href="{{ route('employer.candidates.index') }}" icon="users" label="Browse Candidates" :active="request()->routeIs('employer.candidates.*')" />
    <x-admin-sidebar-item href="{{ route('employer.interviews.index') }}" icon="calendar" label="Interviews" :active="request()->routeIs('employer.interviews.*')" />
    <x-admin-sidebar-item href="{{ route('employer.consultations.index') }}" icon="messages-square" label="Consultations" :active="request()->routeIs('employer.consultations.*')" />
@endsection