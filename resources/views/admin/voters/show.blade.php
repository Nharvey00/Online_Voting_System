<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Details — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <div class="bg-white border-b border-gray-200 px-8 py-4">
            <a href="{{ route('admin.voters.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Voters
            </a>
            <h1 class="text-xl font-extrabold text-gray-900">Voter Details</h1>
        </div>

        <main class="flex-1 p-8">

            <div class="grid grid-cols-3 gap-6">

                {{-- Left: Profile --}}
                <div class="col-span-1 space-y-4">

                    <div class="bg-white border border-gray-200 rounded-lg p-5 text-center">
                        <img src="{{ asset('storage/' . $user->profile_photo) }}"
                            class="w-20 h-20 rounded-full object-cover border-2 border-blue-100 mx-auto mb-3">
                        <h3 class="font-bold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-gray-400 text-sm mt-0.5">{{ $user->email }}</p>
                        <div class="mt-3">
                            @if($user->isCandidate())
                                <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Approved Candidate
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                                    Voter
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-5 space-y-3 text-sm">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Personal Info</h4>
                        <div>
                            <p class="text-xs text-gray-400">Birthdate</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $user->birthdate->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Address</p>
                            <p class="font-semibold text-gray-700 mt-0.5">
                                {{ $user->address }}, {{ $user->barangay }}, {{ $user->city }}, {{ $user->province }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Registered On</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $user->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                </div>

                {{-- Right: ID + Application --}}
                <div class="col-span-2 space-y-4">

                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Submitted ID</h4>
                        <div class="grid grid-cols-2 gap-4 mb-4 text-sm">
                            <div>
                                <p class="text-xs text-gray-400">ID Type</p>
                                <p class="font-semibold text-gray-700 mt-0.5">{{ $user->id_type }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">ID Number</p>
                                <p class="font-semibold text-gray-700 mt-0.5">{{ $user->id_number }}</p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mb-2">ID Photo</p>
                        <img src="{{ asset('storage/' . $user->id_photo) }}"
                            class="w-full max-w-sm rounded-lg border border-gray-200 object-cover">
                    </div>

                    @if($application)
                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Candidate Application</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-400">Election</p>
                                    <p class="font-semibold text-gray-700 mt-0.5">{{ $application->election->title }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400">Position</p>
                                    <p class="font-semibold text-gray-700 mt-0.5">{{ $application->position->name }}</p>
                                </div>
                                <div>
                                    @if($application->isPending())
                                        <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-semibold">Pending</span>
                                    @elseif($application->isApproved())
                                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold">Approved</span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-200 px-2.5 py-1 rounded-full text-xs font-semibold">Rejected</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400">Platform</p>
                                <p class="text-gray-600 text-sm leading-relaxed mt-1 whitespace-pre-line">{{ $application->platform }}</p>
                            </div>
                            <div>
                                <a href="{{ asset('storage/' . $application->document) }}" target="_blank"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg text-sm font-semibold hover:bg-blue-100 transition">
                                    View Submitted Document
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

        </main>
    </div>

</body>
</html>