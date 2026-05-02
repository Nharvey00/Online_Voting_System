<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    @include('voter.partials.navbar')

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="border-b border-green-200 bg-green-50 px-6 py-3">
            <div class="max-w-5xl mx-auto text-sm text-green-700 font-medium">
                {{ session('success') }}
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="border-b border-red-200 bg-red-50 px-6 py-3">
            <div class="max-w-5xl mx-auto text-sm text-red-700 font-medium">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="max-w-5xl mx-auto px-6 py-8">

        <div class="flex gap-6">

            {{-- LEFT: Profile --}}
            <aside class="w-64 flex-shrink-0 space-y-4">

                {{-- Profile Card --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <div class="flex flex-col items-center text-center">
                        <img src="{{ asset('storage/' . $user->profile_photo) }}"
                            class="w-16 h-16 rounded-full object-cover border-2 border-gray-100 mb-3">
                        <h2 class="font-bold text-gray-900 text-base leading-tight">{{ $user->name }}</h2>
                        <p class="text-gray-400 text-xs mt-0.5">{{ $user->email }}</p>
                        <div class="mt-3">
                            @if($user->isCandidate())
                                <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Candidate
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                    Registered Voter
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Info --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5 space-y-3">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Account Details</h3>
                    <div>
                        <p class="text-xs text-gray-400">Birthdate</p>
                        <p class="text-sm font-semibold text-gray-700 mt-0.5">
                            {{ $user->birthdate->format('M d, Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Address</p>
                        <p class="text-sm font-semibold text-gray-700 mt-0.5">
                            {{ $user->barangay }}, {{ $user->city }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">ID on File</p>
                        <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $user->id_type }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400">Member Since</p>
                        <p class="text-sm font-semibold text-gray-700 mt-0.5">
                            {{ $user->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>

            </aside>

            {{-- RIGHT: Main --}}
            <main class="flex-1 space-y-4">

                {{-- Election Status Banner --}}
                @if(!$election)
                    <div class="bg-white border border-gray-200 rounded-lg p-6 text-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-700">No election at the moment</p>
                        <p class="text-gray-400 text-sm mt-1">
                            You will be notified when a new election is available.
                        </p>
                    </div>

                @else

                    {{-- Election Card --}}
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">

                        {{-- Top status bar --}}
                        @if($election->isOngoing() && !$hasVoted)
                            <div class="bg-blue-700 px-5 py-2.5 flex items-center gap-2">
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                <p class="text-white text-xs font-semibold">Voting is now open — cast your vote below</p>
                            </div>
                        @elseif($election->isOngoing() && $hasVoted)
                            <div class="bg-green-600 px-5 py-2.5 flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-white text-xs font-semibold">Your vote has been recorded</p>
                            </div>
                        @elseif($election->isDraft())
                            <div class="bg-amber-500 px-5 py-2.5 flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-white text-xs font-semibold">Upcoming election — voting has not started yet</p>
                            </div>
                        @elseif($election->isClosed())
                            <div class="bg-gray-600 px-5 py-2.5 flex items-center gap-2">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"/>
                                </svg>
                                <p class="text-white text-xs font-semibold">
                                    Election has ended
                                    {{ $election->results_published ? '— results are now available' : '— results will be published soon' }}
                                </p>
                            </div>
                        @endif

                        <div class="p-5">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $election->title }}</h3>
                                    @if($election->description)
                                        <p class="text-gray-500 text-sm mt-1">{{ $election->description }}</p>
                                    @endif
                                    <div class="flex gap-4 mt-2">
                                        <span class="text-xs text-gray-400">
                                            Opens {{ $election->start_at->format('M d, Y') }}
                                        </span>
                                        <span class="text-xs text-gray-400">
                                            Closes {{ $election->end_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Single primary action --}}
                            <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-100">

                                @if($canVote)
                                    <a href="{{ route('vote.index') }}"
                                        class="px-6 py-2.5 bg-blue-700 text-white text-sm font-bold rounded-lg hover:bg-blue-800 transition">
                                        Cast Your Vote
                                    </a>
                                @endif

                                @if($canApply)
                                    <a href="{{ route('candidate.apply') }}"
                                        class="px-5 py-2.5 bg-white text-blue-700 border border-blue-200 text-sm font-semibold rounded-lg hover:bg-blue-50 transition">
                                        Apply as Candidate
                                    </a>
                                @endif

                                @if($election && in_array($election->status, ['draft', 'ongoing']))
                                    <a href="{{ route('voter.candidates') }}"
                                        class="px-5 py-2.5 bg-white text-gray-600 border border-gray-200 text-sm font-semibold rounded-lg hover:bg-gray-50 transition">
                                        View Candidates
                                    </a>
                                @endif

                                @if($canViewResults)
                                    <a href="{{ route('vote.results') }}"
                                        class="px-5 py-2.5 bg-white text-gray-600 border border-gray-200 text-sm font-semibold rounded-lg hover:bg-gray-50 transition">
                                        View Results
                                    </a>
                                @endif

                            </div>
                        </div>
                    </div>

                @endif

                {{-- Candidate Application Status --}}
                @if($application)
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                        Your Candidate Application
                    </h3>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="font-bold text-gray-900">{{ $application->position->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                Submitted {{ $application->created_at->format('M d, Y') }}
                            </p>
                        </div>
                        @if($application->isPending())
                            <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                Under Review
                            </span>
                        @elseif($application->isApproved())
                            <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                Approved
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                Not Approved
                            </span>
                        @endif
                    </div>

                    @if($application->isRejected() && $application->remarks)
                        <div class="mt-3 bg-red-50 border border-red-100 rounded-lg p-3">
                            <p class="text-xs text-red-500 font-semibold mb-1">Reason</p>
                            <p class="text-sm text-red-700">{{ $application->remarks }}</p>
                        </div>
                    @endif

                    @if($application->isApproved())
                        <div class="mt-3 bg-green-50 border border-green-100 rounded-lg p-3">
                            <p class="text-sm text-green-700">
                                Your name is listed on the official ballot for
                                <span class="font-bold">{{ $application->position->name }}</span>.
                            </p>
                        </div>
                    @endif

                    <div class="mt-3 pt-3 border-t border-gray-100">
                        <a href="{{ route('candidate.status') }}"
                            class="text-sm text-blue-700 font-semibold hover:underline">
                            View application details
                        </a>
                    </div>
                </div>
                @endif

                {{-- Votes Summary --}}
                @if($userVotes->isNotEmpty())
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                        Your Ballot
                    </h3>
                    <div class="divide-y divide-gray-100">
                        @foreach($userVotes as $vote)
                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('storage/' . $vote->candidate->user->profile_photo) }}"
                                    class="w-8 h-8 rounded-full object-cover border border-gray-200 flex-shrink-0">
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $vote->candidate->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-400">{{ $vote->position->name }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                                Voted
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </main>
        </div>
    </div>

</body>
</html>