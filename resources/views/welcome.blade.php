<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoteSystem — Secure Online Voting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen flex flex-col">

    {{-- Navbar --}}
    <header class="w-full border-b border-gray-200 bg-white sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-700 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="text-gray-900 font-bold text-lg tracking-tight">VoteSystem</span>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}"
                    class="px-4 py-2 text-sm font-semibold text-blue-700 border border-blue-200 rounded-lg hover:bg-blue-50 transition">
                    Sign In
                </a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 text-sm font-semibold text-white bg-blue-700 rounded-lg hover:bg-blue-800 transition">
                    Create Account
                </a>
                <a href="{{ route('admin.login') }}"
                    class="px-3 py-2 text-xs font-medium text-gray-400 border border-gray-200 rounded-lg hover:bg-gray-50 hover:text-gray-500 transition">
                    Admin
                </a>
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="flex-1 flex items-center justify-center bg-gradient-to-b from-blue-50 to-white px-6 py-28">
        <div class="max-w-2xl text-center">

            <div class="inline-flex items-center gap-2 bg-white border border-blue-100 shadow-sm px-4 py-1.5 rounded-full mb-8">
                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                <span class="text-gray-600 text-xs font-semibold">Platform is live and accepting registrations</span>
            </div>

            <h1 class="text-5xl font-extrabold text-gray-900 leading-tight tracking-tight mb-5">
                Participate in elections<br class="hidden sm:block"> from anywhere.
            </h1>

            <p class="text-gray-500 text-lg leading-relaxed max-w-lg mx-auto mb-10">
                Register with a valid ID, cast your vote securely, and view results in real time.
                A straightforward platform built for transparent elections.
            </p>

            <div class="flex justify-center gap-3 flex-wrap">
                <a href="{{ route('register') }}"
                    class="px-7 py-3 bg-blue-700 text-white font-bold rounded-lg hover:bg-blue-800 transition text-sm shadow-sm">
                    Register to Vote
                </a>
                <a href="{{ route('login') }}"
                    class="px-7 py-3 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition text-sm">
                    Sign In
                </a>
            </div>

        </div>
    </section>

    {{-- 3 Columns --}}
    <section class="bg-white border-t border-gray-100 py-20 px-6">
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-10">

            <div>
                <div class="w-10 h-10 bg-blue-50 border border-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Identity Verified</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Registration requires a valid government-issued ID to ensure only eligible participants can vote.
                </p>
            </div>

            <div>
                <div class="w-10 h-10 bg-blue-50 border border-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">One Vote Per Person</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Each registered voter may cast exactly one vote per position. Submissions are final and cannot be altered.
                </p>
            </div>

            <div>
                <div class="w-10 h-10 bg-blue-50 border border-blue-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Transparent Results</h3>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Vote counts update in real time during the election. Final results are published officially by the administrator.
                </p>
            </div>

        </div>
    </section>

    {{-- How it works --}}
    <section class="bg-gray-50 border-t border-gray-100 py-20 px-6">
        <div class="max-w-4xl mx-auto">

            <div class="text-center mb-12">
                <h2 class="text-2xl font-extrabold text-gray-900">How it works</h2>
                <p class="text-gray-500 text-sm mt-2">Four simple steps from registration to results</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach([
                    ['Step 1', 'Register', 'Create an account using your email and a valid government ID.'],
                    ['Step 2', 'Apply', 'Optionally apply to run as a candidate for any open position.'],
                    ['Step 3', 'Vote', 'During the election period, cast your vote for each position.'],
                    ['Step 4', 'Results', 'View the live tally and final published results.'],
                ] as $step)
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <p class="text-xs font-bold text-blue-600 uppercase tracking-widest mb-2">{{ $step[0] }}</p>
                    <h4 class="font-bold text-gray-900 mb-1.5">{{ $step[1] }}</h4>
                    <p class="text-gray-500 text-xs leading-relaxed">{{ $step[2] }}</p>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-blue-700 py-16 px-6">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-3xl font-extrabold text-white mb-3">Ready to participate?</h2>
            <p class="text-blue-200 text-sm leading-relaxed mb-8">
                Create your account today. Registration only takes a few minutes.
            </p>
            <a href="{{ route('register') }}"
                class="inline-block px-8 py-3 bg-white text-blue-700 font-bold rounded-lg hover:bg-blue-50 transition text-sm shadow-sm">
                Create My Account
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 py-5 px-6">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 bg-blue-700 rounded flex items-center justify-center">
                    <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="text-gray-600 font-semibold text-sm">VoteSystem</span>
            </div>
            <p class="text-gray-400 text-xs">&copy; {{ date('Y') }} VoteSystem. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>