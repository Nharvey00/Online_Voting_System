<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        {{-- Top Bar --}}
        <div class="bg-white border-b border-gray-200 px-8 py-4">
            <h1 class="text-xl font-extrabold text-gray-900">Dashboard</h1>
            <p class="text-gray-400 text-sm mt-0.5">Overview of the voting system</p>
        </div>

        <main class="flex-1 p-8">

            {{-- Stats --}}
            <div class="grid grid-cols-4 gap-5 mb-8">

                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Total Voters</p>
                        <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-gray-900">{{ $totalVoters }}</p>
                    <p class="text-xs text-gray-400 mt-1">Registered accounts</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Active Election</p>
                        <div class="w-8 h-8 bg-green-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-lg font-extrabold text-gray-900 leading-tight">
                        {{ $activeElection ? \Illuminate\Support\Str::limit($activeElection->title, 22) : '—' }}
                    </p>
                    <p class="text-xs mt-1">
                        @if($activeElection)
                            <span class="inline-flex items-center gap-1 {{ $activeElection->isOngoing() ? 'text-green-600' : 'text-amber-600' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $activeElection->isOngoing() ? 'bg-green-500 animate-pulse' : 'bg-amber-500' }}"></span>
                                {{ ucfirst($activeElection->status) }}
                            </span>
                        @else
                            <span class="text-gray-400">No active election</span>
                        @endif
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Pending Applications</p>
                        <div class="w-8 h-8 bg-amber-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold {{ $pendingApplications > 0 ? 'text-amber-600' : 'text-gray-900' }}">
                        {{ $pendingApplications }}
                    </p>
                    <p class="text-xs text-gray-400 mt-1">Awaiting review</p>
                </div>

                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Votes Cast</p>
                        <div class="w-8 h-8 bg-purple-50 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-extrabold text-gray-900">{{ $totalVotesCast }}</p>
                    <p class="text-xs text-gray-400 mt-1">In current election</p>
                </div>

            </div>

            <div class="grid grid-cols-3 gap-6">

                {{-- Active Election Detail --}}
                <div class="col-span-2">
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-bold text-gray-900 text-sm">Current Election</h3>
                            <a href="{{ route('admin.elections.index') }}"
                                class="text-blue-700 text-xs font-semibold hover:underline">
                                Manage all elections
                            </a>
                        </div>
                        @if($activeElection)
                        <div class="p-5">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h4 class="font-bold text-gray-900">{{ $activeElection->title }}</h4>
                                    @if($activeElection->description)
                                        <p class="text-gray-500 text-sm mt-1">{{ $activeElection->description }}</p>
                                    @endif
                                </div>
                                @if($activeElection->isDraft())
                                    <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                        Draft
                                    </span>
                                @elseif($activeElection->isOngoing())
                                    <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold flex-shrink-0">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                        Ongoing
                                    </span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-400">Start</p>
                                    <p class="font-semibold text-gray-700 mt-0.5 text-xs">{{ $activeElection->start_at->format('M d, Y h:i A') }}</p>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    <p class="text-xs text-gray-400">End</p>
                                    <p class="font-semibold text-gray-700 mt-0.5 text-xs">{{ $activeElection->end_at->format('M d, Y h:i A') }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-3 gap-3">
                                <div class="text-center bg-blue-50 rounded-lg p-3">
                                    <p class="text-xl font-extrabold text-blue-700">{{ $activeElection->positions()->count() }}</p>
                                    <p class="text-xs text-blue-600 mt-0.5">Positions</p>
                                </div>
                                <div class="text-center bg-green-50 rounded-lg p-3">
                                    <p class="text-xl font-extrabold text-green-700">{{ $activeElection->candidates()->where('status', 'approved')->count() }}</p>
                                    <p class="text-xs text-green-600 mt-0.5">Candidates</p>
                                </div>
                                <div class="text-center bg-purple-50 rounded-lg p-3">
                                    <p class="text-xl font-extrabold text-purple-700">{{ $totalVotesCast }}</p>
                                    <p class="text-xs text-purple-600 mt-0.5">Voted</p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="p-10 text-center">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-sm font-medium">No active election</p>
                            <a href="{{ route('admin.elections.create') }}"
                                class="mt-3 inline-block bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-bold hover:bg-blue-800 transition">
                                Create Election
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Recent Applications --}}
                <div class="col-span-1">
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="font-bold text-gray-900 text-sm">Recent Applications</h3>
                            <a href="{{ route('admin.candidates.index') }}"
                                class="text-blue-700 text-xs font-semibold hover:underline">
                                View all
                            </a>
                        </div>
                        @if($recentApplications->isEmpty())
                            <div class="p-8 text-center">
                                <p class="text-gray-400 text-sm">No applications yet</p>
                            </div>
                        @else
                            <div class="divide-y divide-gray-100">
                                @foreach($recentApplications as $app)
                                <div class="flex items-center gap-3 px-4 py-3">
                                    <img src="{{ asset('storage/' . $app->user->profile_photo) }}"
                                        class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $app->user->name }}</p>
                                        <p class="text-xs text-gray-400 truncate">{{ $app->position->name }}</p>
                                    </div>
                                    @if($app->isPending())
                                        <span class="w-2 h-2 bg-amber-400 rounded-full flex-shrink-0"></span>
                                    @elseif($app->isApproved())
                                        <span class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0"></span>
                                    @else
                                        <span class="w-2 h-2 bg-red-400 rounded-full flex-shrink-0"></span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        </main>
    </div>

</body>
</html>