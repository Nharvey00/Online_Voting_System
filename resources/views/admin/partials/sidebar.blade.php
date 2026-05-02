<aside class="w-60 bg-white border-r border-gray-200 min-h-screen flex flex-col flex-shrink-0">

    {{-- Logo --}}
    <div class="px-5 py-5 border-b border-gray-200">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div>
                <p class="font-bold text-gray-900 text-sm">VoteSystem</p>
                <p class="text-gray-400 text-xs">Admin Panel</p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 px-3 py-4 space-y-0.5">

        @php
            $navItems = [
                ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                ['route' => 'admin.elections.index', 'label' => 'Elections', 'icon' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                ['route' => 'admin.candidates.index', 'label' => 'Applications', 'icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
                ['route' => 'admin.voters.index', 'label' => 'Voters', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['route' => 'admin.results.index', 'label' => 'Results', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z'],
            ];
        @endphp

        @foreach($navItems as $item)
        <a href="{{ route($item['route']) }}"
            class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition
            {{ request()->routeIs($item['route']) || request()->routeIs($item['route'] . '.*')
                ? 'bg-blue-50 text-blue-700'
                : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
            </svg>
            {{ $item['label'] }}
        </a>
        @endforeach

    </nav>

    {{-- Admin User + Logout --}}
    <div class="px-3 py-4 border-t border-gray-200">
        <div class="flex items-center gap-3 px-3 py-2 mb-2">
            <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-blue-700 text-xs font-bold">
                    {{ strtoupper(substr(Auth::guard('admin')->user()->name, 0, 1)) }}
                </span>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-semibold text-gray-900 truncate">{{ Auth::guard('admin')->user()->name }}</p>
                <p class="text-xs text-gray-400">Administrator</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-2 px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>

</aside>