<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex bg-white">

    {{-- Left Branding --}}
    <div class="hidden lg:flex w-1/2 bg-blue-700 flex-col justify-between p-12 relative overflow-hidden">

        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-[-100px] left-[-100px] w-96 h-96 bg-blue-600 rounded-full opacity-30"></div>
            <div class="absolute bottom-[-80px] right-[-80px] w-80 h-80 bg-blue-800 rounded-full opacity-30"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-blue-600 rounded-full opacity-10"></div>
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-xl">VoteSystem</span>
            </div>
        </div>

        <div class="relative z-10">
            <h2 class="text-4xl font-extrabold text-white leading-tight mb-4">
                Welcome back to the platform.
            </h2>
            <p class="text-blue-200 text-base leading-relaxed mb-10">
                Login to access your voter account, track your application status, and participate in active elections.
            </p>

            <div class="space-y-4">
                @foreach([
                    ['Verified voter registration', 'Your identity is confirmed before you vote.'],
                    ['One vote per position', 'Fair and tamper-proof ballot system.'],
                    ['Live vote counting', 'See results update in real time.'],
                ] as $feature)
                <div class="flex items-start gap-3">
                    <div class="w-5 h-5 bg-blue-500 rounded flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold">{{ $feature[0] }}</p>
                        <p class="text-blue-200 text-xs mt-0.5">{{ $feature[1] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="relative z-10">
            <p class="text-blue-300 text-xs">&copy; {{ date('Y') }} VoteSystem. All rights reserved.</p>
        </div>
    </div>

    {{-- Right Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-8 py-12 bg-gray-50">
        <div class="w-full max-w-md">

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">Sign in</h1>
                <p class="text-gray-500 text-sm mt-2">Enter your credentials to access your account</p>
            </div>

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" autofocus required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-900
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                        bg-white transition placeholder-gray-400"
                        placeholder="you@example.com">
                    @error('email') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-900
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                        bg-white transition placeholder-gray-400"
                        placeholder="Enter your password">
                    @error('password') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                            class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-blue-700 text-white py-2.5 rounded-lg font-bold text-sm
                    hover:bg-blue-800 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Sign In
                </button>

            </form>

            <div class="mt-6 pt-6 border-t border-gray-200 space-y-3 text-center">
                <p class="text-sm text-gray-500">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-blue-700 font-semibold hover:underline">
                        Create one here
                    </a>
                </p>
                <p class="text-xs text-gray-400">
                    Admin?
                    <a href="{{ route('admin.login') }}" class="text-gray-500 hover:underline font-medium">
                        Access admin portal
                    </a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>