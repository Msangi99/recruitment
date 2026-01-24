@section('page_label', 'Candidate')
@section('sidebar')
    <x-admin-sidebar-item variant="candidate" href="{{ route('candidate.dashboard') }}" icon="layout-dashboard"
        label="Dashboard" :active="request()->routeIs('candidate.dashboard')" />
    <x-admin-sidebar-item variant="candidate" href="{{ route('candidate.profile.show') }}" icon="user" label="Profile"
        :active="request()->routeIs('candidate.profile.*')" />
    <x-admin-sidebar-item variant="candidate" href="{{ route('candidate.jobs.index') }}" icon="briefcase"
        label="Browse Jobs" :active="request()->routeIs('candidate.jobs.*')" />
    <x-admin-sidebar-item variant="candidate" href="{{ route('candidate.applications.index') }}" icon="file-text"
        label="My Applications" :active="request()->routeIs('candidate.applications.*')" />
    <x-admin-sidebar-item variant="candidate" href="{{ route('candidate.documents.index') }}" icon="folder"
        label="Documents" :active="request()->routeIs('candidate.documents.*')" />
    <x-admin-sidebar-item variant="candidate" href="{{ route('candidate.consultations.index') }}" icon="messages-square"
        label="Consultations" :active="request()->routeIs('candidate.consultations.*')" />
    {{-- <x-admin-sidebar-item variant="candidate" href="{{ route('candidate.billing.index') }}" icon="credit-card"
        label="Billing" :active="request()->routeIs('candidate.billing.*')" /> --}}
@endsection