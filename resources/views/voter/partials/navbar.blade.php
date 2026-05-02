<header class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">

        {{-- Logo --}}
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <span class="font-bold text-gray-900 text-base">VoteSystem</span>
        </div>

        {{-- Nav Links --}}
        <nav class="hidden md:flex items-center gap-1">
            <a href="{{ route('voter.dashboard') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('voter.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                Dashboard
            </a>
            <a href="{{ route('voter.candidates') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('voter.candidates') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                Candidates
            </a>
            <a href="{{ route('vote.index') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('vote.index') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                Vote
            </a>
            <a href="{{ route('vote.results') }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition
                {{ request()->routeIs('vote.results') ? 'bg-blue-50 text-blue-700' : 'text-gray-600 hover:bg-gray-100' }}">
                Results
            </a>
        </nav>

        {{-- User + Logout --}}
        <div class="flex items-center gap-3">
            <div class="hidden md:flex items-center gap-2">
                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                    class="w-7 h-7 rounded-full object-cover border border-gray-200">
                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 text-sm font-semibold text-gray-600 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Logout
                </button>
            </form>
        </div>

    </div>
</header>