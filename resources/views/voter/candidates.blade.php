<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidates — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    @include('voter.partials.navbar')

    <div class="max-w-5xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="mb-7 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Candidates</h1>
                <p class="text-gray-500 text-sm mt-1">
                    {{ $election->title }}
                    <span class="ml-2 inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full
                        {{ $election->isOngoing() ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-amber-50 text-amber-700 border border-amber-200' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $election->isOngoing() ? 'bg-green-500 animate-pulse' : 'bg-amber-500' }}"></span>
                        {{ ucfirst($election->status) }}
                    </span>
                </p>
            </div>
            @if($election->isOngoing())
                <a href="{{ route('vote.index') }}"
                    class="px-5 py-2.5 bg-blue-700 text-white text-sm font-bold rounded-lg hover:bg-blue-800 transition">
                    Proceed to Vote
                </a>
            @endif
        </div>

        {{-- Positions --}}
        @foreach($positions as $position)
        <div class="bg-white border border-gray-200 rounded-lg mb-5 overflow-hidden">

            {{-- Position Header --}}
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900">{{ $position->name }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">
                        {{ $position->candidates->count() }} approved candidate(s)
                    </p>
                </div>
                <span class="text-xs font-semibold text-gray-400 bg-gray-100 px-3 py-1 rounded-full">
                    {{ $position->max_winners === 1 ? 'Single Winner' : $position->max_winners . ' Winners' }}
                </span>
            </div>

            {{-- Candidates --}}
            <div class="p-6">
                @if($position->candidates->isEmpty())
                    <div class="text-center py-8">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <p class="text-gray-400 text-sm">No approved candidates for this position yet</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($position->candidates as $candidate)
                        <div class="flex items-start gap-4 p-4 border border-gray-100 rounded-lg hover:border-blue-200 hover:bg-blue-50 transition w-full">
                            <img src="{{ asset('storage/' . $candidate->user->profile_photo) }}"
                                class="w-12 h-12 rounded-full object-cover border-2 border-gray-100 flex-shrink-0">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="font-bold text-gray-900 text-sm">{{ $candidate->user->name }}</p>
                                    <span class="text-xs text-gray-400 flex-shrink-0 ml-2">
                                        {{ $candidate->user->city }}, {{ $candidate->user->province }}
                                    </span>
                                </div>
                                <p class="text-gray-500 text-xs mt-1.5 leading-relaxed break-words line-clamp-2">
                                    {{ $candidate->platform }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
        @endforeach

    </div>

</body>
</html>