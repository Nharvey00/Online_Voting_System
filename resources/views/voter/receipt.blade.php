<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vote Receipt — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4 py-12">

    <div class="w-full max-w-md">

        {{-- Receipt Card --}}
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">

            {{-- Header --}}
            <div class="bg-blue-700 px-6 py-8 text-center">
                <div class="w-14 h-14 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-white font-extrabold text-xl">Votes Submitted</h1>
                <p class="text-blue-200 text-sm mt-1">{{ $election }}</p>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5">

                <div class="bg-amber-50 border border-amber-100 rounded-lg px-4 py-3 mb-5">
                    <p class="text-amber-700 text-xs font-semibold">
                        This receipt is shown once only. It will not be available after you leave this page.
                    </p>
                </div>

                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Your Ballot</h3>

                <div class="divide-y divide-gray-100">
                    @foreach($receipt as $item)
                    <div class="flex items-center justify-between py-3">
                        <span class="text-sm text-gray-500">{{ $item['position'] }}</span>
                        <span class="text-sm font-bold text-gray-900">{{ $item['candidate'] }}</span>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 pt-5 border-t border-gray-100 space-y-2">
                    <a href="{{ route('vote.results') }}"
                        class="block w-full text-center bg-blue-700 text-white py-2.5 rounded-lg font-bold text-sm hover:bg-blue-800 transition">
                        View Live Tally
                    </a>
                    <a href="{{ route('voter.dashboard') }}"
                        class="block w-full text-center bg-white border border-gray-200 text-gray-600 py-2.5 rounded-lg font-semibold text-sm hover:bg-gray-50 transition">
                        Back to Dashboard
                    </a>
                </div>

            </div>

        </div>

        <p class="text-center text-gray-400 text-xs mt-4">
            Your vote has been securely recorded in the system.
        </p>

    </div>

</body>
</html>