@extends('layouts.admin')

@section('content')
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900">Consultation Details</h2>
            <a href="{{ route('admin.consultations.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to
                List</a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Request Information</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Details about the consultation request.</p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $consultation->name }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Type</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ ucfirst(str_replace('_', ' ', $consultation->type)) }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Email address</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $consultation->email }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Phone</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $consultation->phone }}</dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Company</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $consultation->company ?? 'N/A' }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Country</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $consultation->country ?? 'N/A' }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Requested Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if($consultation->requested_date)
                                {{ $consultation->requested_date->format('F d, Y h:i A') }}
                            @else
                                Not Scheduled
                            @endif
                        </dd>
                    </div>

                    @if($consultation->type == 'job_seeker')
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $consultation->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($consultation->payment_status) }}
                                </span>
                                @if($consultation->amount)
                                    - {{ number_format($consultation->amount) }} TZS
                                @endif
                                @if($consultation->payment_gateway)
                                    via {{ ucfirst($consultation->payment_gateway) }}
                                @endif
                            </dd>
                        </div>
                    @endif

                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Additional Data</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            @if(is_array($consultation->meta_data) && count($consultation->meta_data) > 0)
                                <div class="border border-gray-200 rounded-md overflow-hidden">
                                    <dl class="divide-y divide-gray-200">
                                        @foreach($consultation->meta_data as $key => $value)
                                            <div class="px-4 py-3 grid grid-cols-3 gap-4 bg-white hover:bg-gray-50">
                                                <dt class="text-xs font-bold text-gray-500 uppercase tracking-wider">
                                                    {{ str_replace('_', ' ', $key) }}</dt>
                                                <dd class="text-sm text-gray-900 col-span-2 mt-0">
                                                    @if(is_array($value))
                                                        {{ json_encode($value) }}
                                                    @else
                                                        {{ $value }}
                                                    @endif
                                                </dd>
                                            </div>
                                        @endforeach
                                    </dl>
                                </div>
                            @else
                                <span class="text-gray-500 italic">No additional data provided.</span>
                            @endif
                        </dd>
                    </div>

                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Update Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <form action="{{ route('admin.consultations.updateStatus', $consultation->id) }}" method="POST"
                                class="flex items-center gap-4">
                                @csrf
                                @method('PATCH')
                                <select name="status"
                                    class="rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="pending" {{ $consultation->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="pending_review" {{ $consultation->status == 'pending_review' ? 'selected' : '' }}>Reviewing</option>
                                    <option value="confirmed" {{ $consultation->status == 'confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="completed" {{ $consultation->status == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="cancelled" {{ $consultation->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                                <button type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Update
                                </button>
                            </form>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
@endsection