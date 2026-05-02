<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Application — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <div class="bg-white border-b border-gray-200 px-8 py-4">
            <a href="{{ route('admin.candidates.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Applications
            </a>
            <h1 class="text-xl font-extrabold text-gray-900">Review Application</h1>
        </div>

        <main class="flex-1 p-8">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error') || $errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm font-medium">
                    {{ session('error') ?? $errors->first() }}
                </div>
            @endif

            <div class="grid grid-cols-3 gap-6">

                {{-- Left: Applicant Info --}}
                <div class="col-span-1 space-y-4">

                    <div class="bg-white border border-gray-200 rounded-lg p-5 text-center">
                        <img src="{{ asset('storage/' . $candidate->user->profile_photo) }}"
                            class="w-20 h-20 rounded-full object-cover border-2 border-blue-100 mx-auto mb-3">
                        <h3 class="font-bold text-gray-900">{{ $candidate->user->name }}</h3>
                        <p class="text-gray-400 text-sm mt-0.5">{{ $candidate->user->email }}</p>
                        <div class="mt-3">
                            @if($candidate->isPending())
                                <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></span>
                                    Pending Review
                                </span>
                            @elseif($candidate->isApproved())
                                <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    Approved
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                                    Rejected
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-5 space-y-3 text-sm">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest">Application Details</h4>
                        <div>
                            <p class="text-xs text-gray-400">Election</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $candidate->election->title }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Running For</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $candidate->position->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Applied On</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $candidate->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">ID Type</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $candidate->user->id_type }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">ID Number</p>
                            <p class="font-semibold text-gray-700 mt-0.5">{{ $candidate->user->id_number }}</p>
                        </div>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">ID Photo</h4>
                        <img src="{{ asset('storage/' . $candidate->user->id_photo) }}"
                            class="w-full rounded-lg border border-gray-200 object-cover">
                    </div>

                </div>

                {{-- Right: Platform + Actions --}}
                <div class="col-span-2 space-y-4">

                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Platform / Bio</h4>
                        <p class="text-gray-700 text-sm leading-relaxed whitespace-pre-line">{{ $candidate->platform }}</p>
                    </div>

                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Supporting Document</h4>
                        <a href="{{ asset('storage/' . $candidate->document) }}" target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 border border-blue-200 rounded-lg text-sm font-semibold hover:bg-blue-100 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            View Document
                        </a>
                    </div>

                    @if($candidate->isRejected() && $candidate->remarks)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-5">
                        <h4 class="text-xs font-bold text-red-500 uppercase tracking-widest mb-2">Rejection Reason</h4>
                        <p class="text-red-700 text-sm">{{ $candidate->remarks }}</p>
                    </div>
                    @endif

                    @if($candidate->isPending())
                    <div class="bg-white border border-gray-200 rounded-lg p-5">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Review Decision</h4>

                        <div class="flex gap-4">

                            {{-- Approve --}}
                            <form method="POST" action="{{ route('admin.candidates.approve', $candidate) }}">
                                @csrf @method('PATCH')
                                <button type="submit"
                                    onclick="return confirm('Approve this candidate?')"
                                    class="px-6 py-2.5 bg-green-600 text-white font-bold text-sm rounded-lg hover:bg-green-700 transition">
                                    Approve Candidate
                                </button>
                            </form>

                            {{-- Reject --}}
                            <div class="flex-1">
                                <form method="POST" action="{{ route('admin.candidates.reject', $candidate) }}">
                                    @csrf @method('PATCH')
                                    <textarea name="remarks" rows="2" required
                                        placeholder="State your reason for rejection..."
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm
                                        focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-transparent
                                        resize-none mb-2">{{ old('remarks') }}</textarea>
                                    @error('remarks')
                                        <p class="text-red-500 text-xs mb-2">{{ $message }}</p>
                                    @enderror
                                    <button type="submit"
                                        onclick="return confirm('Reject this application?')"
                                        class="px-6 py-2.5 bg-red-600 text-white font-bold text-sm rounded-lg hover:bg-red-700 transition">
                                        Reject Application
                                    </button>
                                </form>
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