@extends('layouts.admin')

@section('title', 'Pending Verifications')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pending Verifications</h2>
            <p class="text-sm text-gray-500">Review and approve candidate profiles and documents</p>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-gray-200 rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Candidate</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Education & Exp</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Documents</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Submitted</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pendingProfiles as $profile)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('admin.candidates.show', $profile->user) }}" class="flex items-center hover:opacity-75 transition-opacity">
                                    <div class="h-10 w-10 rounded-full bg-gray-100 flex items-center justify-center border border-gray-200">
                                        <span class="text-gray-600 font-bold text-sm">{{ substr($profile->user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900 hover:text-blue-600">{{ $profile->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $profile->user->email }}</div>
                                    </div>
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 font-medium">{{ $profile->education_level ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $profile->years_of_experience ?? '0' }} years experience</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($profile->user->documents->count() > 0)
                                    <a href="{{ route('admin.candidates.show', $profile->user) }}" class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-blue-100 text-blue-700 hover:bg-blue-200 transition-colors cursor-pointer" title="Click to view documents">
                                        {{ $profile->user->documents->count() }} document(s)
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 font-medium italic">No documents</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                {{ $profile->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold">
                                <div class="flex justify-end space-x-2">
                                    <a href="{{ route('admin.candidates.show', $profile->user) }}" class="px-4 py-1.5 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-lg transition-colors">
                                        View Details
                                    </a>
                                    <form method="POST" action="{{ route('admin.verification.profile.approve', $profile) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-1.5 bg-green-100 text-green-700 hover:bg-green-200 rounded-lg transition-colors">
                                            Approve
                                        </button>
                                    </form>
                                    <button type="button" onclick="showRejectModal({{ $profile->id }})" class="px-4 py-1.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-lg transition-colors">
                                        Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500 italic">
                                <div class="flex flex-col items-center">
                                    <i data-lucide="shield-check" class="w-12 h-12 text-gray-300 mb-2"></i>
                                    <p>No pending verifications at the moment.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pendingProfiles->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $pendingProfiles->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="hidden fixed inset-0 z-[60] overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50" @click="closeRejectModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                        <i data-lucide="alert-triangle" class="w-6 h-6 text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg font-bold leading-6 text-gray-900" id="modal-title">Reject Verification</h3>
                        <div class="mt-4">
                            <form id="rejectForm" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Reason for rejection</label>
                                    <textarea name="rejection_reason" rows="4" required 
                                              class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Provide a reason so the candidate can fix the issue..."></textarea>
                                </div>
                                <div class="flex flex-col sm:flex-row-reverse gap-2">
                                    <button type="submit" class="w-full px-6 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors">
                                        Reject Profile
                                    </button>
                                    <button type="button" onclick="closeRejectModal()" class="w-full px-6 py-2 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-colors border border-gray-200">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showRejectModal(profileId) {
    document.getElementById('rejectForm').action = `/admin/verification/profile/${profileId}/reject`;
    document.getElementById('rejectModal').classList.remove('hidden');
    document.body.classList.add('overflow-hidden');
}

function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}
</script>
@endsection
