<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Status — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    @include('voter.partials.navbar')

    <div class="max-w-2xl mx-auto px-6 py-8">

        <div class="mb-7">
            <a href="{{ route('voter.dashboard') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-2xl font-extrabold text-gray-900">Application Status</h1>
            <p class="text-gray-500 text-sm mt-1">Track your candidate application</p>
        </div>

        @if(!$application)
            <div class="bg-white border border-gray-200 rounded-lg p-10 text-center">
                <div class="w-14 h-14 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p class="text-gray-700 font-semibold">No application submitted</p>
                <p class="text-gray-400 text-sm mt-1">You have not applied as a candidate yet.</p>
                <a href="{{ route('candidate.apply') }}"
                    class="mt-5 inline-block bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-blue-800 transition">
                    Apply Now
                </a>
            </div>
        @else
            <div class="space-y-4">

                {{-- Status Card --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Election</p>
                            <p class="font-bold text-gray-900">{{ $application->election->title }}</p>
                        </div>
                        @if($application->isPending())
                            <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                Pending Review
                            </span>
                        @elseif($application->isApproved())
                            <span class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                Approved
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                Rejected
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-gray-100">
                        <div>
                            <p class="text-xs text-gray-400">Position</p>
                            <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $application->position->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Applied On</p>
                            <p class="text-sm font-semibold text-gray-700 mt-0.5">{{ $application->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Platform --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Your Platform</h3>
                    <p class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{ $application->platform }}</p>
                </div>

                {{-- Rejection Reason --}}
                @if($application->isRejected() && $application->remarks)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-5">
                        <h3 class="text-xs font-bold text-red-500 uppercase tracking-widest mb-2">Reason for Rejection</h3>
                        <p class="text-red-700 text-sm">{{ $application->remarks }}</p>
                    </div>
                @endif

                {{-- Approved Notice --}}
                @if($application->isApproved())
                    <div class="bg-green-50 border border-green-200 rounded-lg p-5">
                        <p class="text-green-700 text-sm font-semibold">
                            Your application has been approved.
                        </p>
                        <p class="text-green-600 text-sm mt-1">
                            You are now listed as an official candidate for
                            <span class="font-bold">{{ $application->position->name }}</span>.
                            Your name will appear on the ballot when the election is ongoing.
                        </p>
                    </div>
                @endif

            </div>
        @endif

    </div>

</body>
</html>