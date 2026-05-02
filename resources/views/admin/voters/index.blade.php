<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voters — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <div class="bg-white border-b border-gray-200 px-8 py-4">
            <h1 class="text-xl font-extrabold text-gray-900">Manage Voters</h1>
            <p class="text-gray-400 text-sm mt-0.5">All registered voters in the system</p>
        </div>

        <main class="flex-1 p-8">

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Voter</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Email</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Location</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">ID Type</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Registered</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($voters as $voter)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/' . $voter->profile_photo) }}"
                                        class="w-9 h-9 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $voter->name }}</p>
                                        @if($voter->isCandidate())
                                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-full text-xs font-semibold">
                                                Candidate
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 px-2 py-0.5 rounded-full text-xs font-semibold">
                                                Voter
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $voter->email }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $voter->city }}, {{ $voter->province }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $voter->id_type }}</td>
                            <td class="px-6 py-4 text-gray-400 text-xs">{{ $voter->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.voters.show', $voter) }}"
                                    class="text-xs font-semibold text-blue-700 hover:underline">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">No voters registered yet</p>
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