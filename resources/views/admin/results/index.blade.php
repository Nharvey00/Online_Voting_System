<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <div class="bg-white border-b border-gray-200 px-8 py-4">
            <h1 class="text-xl font-extrabold text-gray-900">Election Results</h1>
            @if($election)
                <div class="flex items-center gap-2 mt-0.5">
                    <p class="text-gray-400 text-sm">{{ $election->title }}</p>
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-0.5 rounded-full border
                        {{ $election->isOngoing() ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-100 text-gray-500 border-gray-200' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $election->isOngoing() ? 'bg-green-500 animate-pulse' : 'bg-gray-400' }}"></span>
                        {{ ucfirst($election->status) }}
                    </span>
                </div>
            @endif
        </div>

        <main class="flex-1 p-8">

            @if(!$election)
                <div class="bg-white border border-gray-200 rounded-lg p-14 text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <p class="text-gray-500 font-medium text-sm">No election results to display yet</p>
                </div>
            @else

                {{-- Turnout Cards --}}
                <div class="grid grid-cols-3 gap-5 mb-7">
                    <div class="bg-white border border-gray-200 rounded-lg p-5 text-center">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Registered Voters</p>
                        <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalVoters }}</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-5 text-center">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Votes Cast</p>
                        <p class="text-3xl font-extrabold text-blue-700 mt-1">{{ $totalVoted }}</p>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-5 text-center">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Voter Turnout</p>
                        <p class="text-3xl font-extrabold text-green-600 mt-1">
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
                        @if($election->results_published)
                            <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                Published
                            </span>
                        @endif
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

                                <img src="{{ asset('storage/' . $candidateResult['photo']) }}"
                                    class="w-10 h-10 rounded-full object-cover border-2 flex-shrink-0
                                    {{ $isWinner ? 'border-amber-300' : 'border-gray-200' }}">

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-1.5">
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-gray-900 text-sm">{{ $candidateResult['candidate'] }}</span>
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

            @endif

        </main>
    </div>

</body>
</html>