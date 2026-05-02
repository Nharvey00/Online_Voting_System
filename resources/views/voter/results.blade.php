<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    @include('voter.partials.navbar')

    <div class="max-w-4xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="mb-7 flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Election Results</h1>
                <div class="flex items-center gap-3 mt-1">
                    <p class="text-gray-500 text-sm">{{ $election->title }}</p>
                    @if($election->isOngoing())
                        <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                            Live
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                            Final Results
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Turnout Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-7">
            <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Registered Voters</p>
                <p class="text-2xl font-extrabold text-gray-900 mt-1">{{ $totalVoters }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Votes Cast</p>
                <p class="text-2xl font-extrabold text-blue-700 mt-1">{{ $totalVoted }}</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-wide">Voter Turnout</p>
                <p class="text-2xl font-extrabold text-green-600 mt-1">
                    {{ $totalVoters > 0 ? round(($totalVoted / $totalVoters) * 100, 1) : 0 }}%
                </p>
            </div>
        </div>

        {{-- Results per position --}}
        @foreach($results as $result)
        <div class="bg-white border border-gray-200 rounded-lg mb-5 overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900">{{ $result['position'] }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $result['total_votes'] }} votes cast</p>
                </div>
            </div>

            <div class="p-6 space-y-4">

                @if(empty($result['candidates']))
                    <div class="text-center py-6">
                        <p class="text-gray-400 text-sm">No votes cast for this position yet</p>
                    </div>
                @else
                    @foreach($result['candidates'] as $index => $candidateResult)
                    @php $isWinner = $election->results_published && $index < $result['max_winners']; @endphp

                    <div class="flex items-center gap-4">

                        {{-- Rank --}}
                        <div class="w-7 text-center flex-shrink-0">
                            @if($isWinner)
                                <div class="w-7 h-7 bg-amber-400 rounded-full flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </div>
                            @else
                                <span class="text-gray-400 text-sm font-bold">#{{ $index + 1 }}</span>
                            @endif
                        </div>

                        {{-- Photo --}}
                        <img src="{{ asset('storage/' . $candidateResult['photo']) }}"
                            class="w-10 h-10 rounded-full object-cover border-2 flex-shrink-0
                            {{ $isWinner ? 'border-amber-300' : 'border-gray-200' }}">

                        {{-- Name + Bar --}}
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1.5">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-gray-900 text-sm">
                                        {{ $candidateResult['candidate'] }}
                                    </span>
                                    @if($isWinner)
                                        <span class="bg-amber-100 text-amber-700 border border-amber-200 px-2 py-0.5 rounded-full text-xs font-bold">
                                            Winner
                                        </span>
                                    @endif
                                </div>
                                <span class="text-gray-500 text-xs font-semibold flex-shrink-0 ml-2">
                                    {{ $candidateResult['votes'] }} votes &mdash; {{ $candidateResult['percentage'] }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5">
                                <div class="h-1.5 rounded-full transition-all duration-500
                                    {{ $isWinner ? 'bg-amber-400' : 'bg-blue-500' }}"
                                    style="width: {{ $candidateResult['percentage'] }}%">
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                @endif

            </div>
        </div>
        @endforeach

        @if($election->isOngoing())
            <p class="text-center text-gray-400 text-xs mt-2">
                Results update on page refresh while the election is ongoing.
            </p>
        @endif

    </div>

</body>
</html>