<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cast Your Vote — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    @include('voter.partials.navbar')

    <div class="max-w-3xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="mb-7">
            <h1 class="text-2xl font-extrabold text-gray-900">Cast Your Vote</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $election->title }}</p>
        </div>

        @if($hasVotedForAll)
            <div class="bg-green-50 border border-green-200 rounded-lg p-5 mb-6 flex items-center gap-4">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-green-700 font-bold text-sm">You have already voted</p>
                    <p class="text-green-600 text-xs mt-0.5">
                        Your votes have been recorded.
                        <a href="{{ route('vote.results') }}" class="underline font-semibold">View live tally</a>
                    </p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        {{-- Notice --}}
        @if(!$hasVotedForAll)
        <div class="bg-blue-50 border border-blue-100 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-700">
                <span class="font-semibold">Important:</span>
                Select one candidate per position. You must vote for all positions before submitting.
                Votes are final and cannot be changed after submission.
            </p>
        </div>
        @endif

        @if(!$hasVotedForAll)
        <form method="POST" action="{{ route('vote.store') }}" id="voteForm">
            @csrf
        @endif

            @foreach($positions as $position)
            <div class="bg-white border border-gray-200 rounded-lg mb-4 overflow-hidden">

                {{-- Position Header --}}
                <div class="px-5 py-3.5 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-gray-900 text-sm">{{ $position->name }}</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Select one candidate</p>
                    </div>
                    @if(in_array($position->id, $votedPositionIds))
                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                            </svg>
                            Voted
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                            Required
                        </span>
                    @endif
                </div>

                {{-- Candidates --}}
                <div class="p-5">
                    @if($position->candidates->isEmpty())
                        <div class="text-center py-6">
                            <p class="text-gray-400 text-sm">No approved candidates for this position</p>
                        </div>
                    @else
                        <div class="space-y-2">
                            @foreach($position->candidates as $candidate)
                            <label class="flex items-center gap-4 p-3.5 border border-gray-200 rounded-lg cursor-pointer
                                hover:border-blue-300 hover:bg-blue-50 transition group
                                {{ in_array($position->id, $votedPositionIds) ? 'opacity-60 cursor-not-allowed' : '' }}">

                                <input type="radio"
                                    name="candidate_{{ $position->id }}"
                                    value="{{ $candidate->id }}"
                                    {{ in_array($position->id, $votedPositionIds) ? 'disabled' : '' }}
                                    class="w-4 h-4 text-blue-600 border-gray-300">

                                <img src="{{ asset('storage/' . $candidate->user->profile_photo) }}"
                                    class="w-11 h-11 rounded-full object-cover border-2 border-gray-100 flex-shrink-0">

                                <div class="flex-1 min-w-0">
                                    <p class="font-bold text-gray-900 text-sm">{{ $candidate->user->name }}</p>
                                    <p class="text-gray-400 text-xs mt-0.5">
                                        {{ $candidate->user->city }}, {{ $candidate->user->province }}
                                    </p>
                                </div>

                            </label>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>
            @endforeach

        @if(!$hasVotedForAll)
            <div class="mt-6 bg-white border border-gray-200 rounded-lg p-5">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Please review your selections carefully before submitting.
                    </p>
                    <button type="submit"
                        onclick="return confirm('Are you sure you want to submit your votes? This action cannot be undone.')"
                        class="px-8 py-2.5 bg-blue-700 text-white font-bold text-sm rounded-lg hover:bg-blue-800 transition">
                        Submit Votes
                    </button>
                </div>
            </div>
        </form>
        @endif

    </div>

</body>
</html>