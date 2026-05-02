<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Applications — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-extrabold text-gray-900">Candidate Applications</h1>
                <p class="text-gray-400 text-sm mt-0.5">
                    {{ $election ? $election->title : 'No active election' }}
                </p>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex items-center gap-1 bg-gray-100 rounded-lg p-1">
                @foreach([
                    ['label' => 'All', 'value' => null],
                    ['label' => 'Pending', 'value' => 'pending'],
                    ['label' => 'Approved', 'value' => 'approved'],
                    ['label' => 'Rejected', 'value' => 'rejected'],
                ] as $filter)
                <a href="{{ route('admin.candidates.index', $filter['value'] ? ['status' => $filter['value']] : []) }}"
                    class="px-3 py-1.5 rounded-md text-xs font-semibold transition
                    {{ request('status') === $filter['value'] || (!request('status') && !$filter['value'])
                        ? 'bg-white text-gray-900 shadow-sm'
                        : 'text-gray-500 hover:text-gray-700' }}">
                    {{ $filter['label'] }}
                </a>
                @endforeach
            </div>
        </div>

        <main class="flex-1 p-8">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Applicant</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Position</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Applied</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($candidates as $candidate)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $candidate->user->profile_photo) }}"
                                        class="w-9 h-9 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $candidate->user->name }}</p>
                                        <p class="text-gray-400 text-xs">{{ $candidate->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-700 font-medium">{{ $candidate->position->name }}</td>
                            <td class="px-6 py-4 text-gray-400 text-xs">{{ $candidate->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                @if($candidate->isPending())
                                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                        Pending
                                    </span>
                                @elseif($candidate->isApproved())
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                        Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.candidates.show', $candidate) }}"
                                    class="text-xs font-semibold text-blue-700 hover:underline">
                                    Review
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">No applications found</p>
                                <p class="text-gray-400 text-xs mt-1">Applications will appear here once voters apply</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

</body>
</html>