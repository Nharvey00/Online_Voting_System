<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex bg-white">

    {{-- Left Branding --}}
    <div class="hidden lg:flex w-1/2 bg-gray-900 flex-col justify-between p-12 relative overflow-hidden">

        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-[-100px] left-[-100px] w-96 h-96 bg-gray-800 rounded-full opacity-50"></div>
            <div class="absolute bottom-[-80px] right-[-80px] w-80 h-80 bg-gray-800 rounded-full opacity-50"></div>
        </div>

        <div class="relative z-10">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span class="text-white font-bold text-xl">VoteSystem</span>
            </div>
        </div>

        <div class="relative z-10">
            <div class="inline-flex items-center gap-2 bg-gray-800 border border-gray-700 px-3 py-1.5 rounded-full mb-6">
                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                <span class="text-gray-400 text-xs font-medium">Admin Portal</span>
            </div>
            <h2 class="text-4xl font-extrabold text-white leading-tight mb-4">
                Manage the election process.
            </h2>
            <p class="text-gray-400 text-base leading-relaxed">
                Access the admin panel to create elections, review candidate applications, and publish results.
            </p>

            <div class="mt-10 space-y-4">
                @foreach([
                    'Create and manage elections',
                    'Review and approve candidates',
                    'Monitor live vote counts',
                    'Publish official results',
                ] as $capability)
                <div class="flex items-center gap-3">
                    <div class="w-5 h-5 bg-blue-600 rounded flex items-center justify-center flex-shrink-0">
                        <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 text-sm">{{ $capability }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div class="relative z-10">
            <p class="text-gray-600 text-xs">&copy; {{ date('Y') }} VoteSystem. All rights reserved.</p>
        </div>
    </div>

    {{-- Right Form --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center px-8 py-12 bg-gray-50">
        <div class="w-full max-w-md">

            <div class="mb-8">
                <h1 class="text-3xl font-extrabold text-gray-900">Admin Sign In</h1>
                <p class="text-gray-500 text-sm mt-2">Enter your admin credentials to continue</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Username</label>
                    <input type="text" name="username" value="{{ old('username') }}" autofocus required
                        placeholder="Enter your username"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-900
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                        bg-white transition">
                    @error('username') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                    <input type="password" name="password" required
                        placeholder="Enter your password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm text-gray-900
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                        bg-white transition">
                    @error('password') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>

                <button type="submit"
                    class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-bold text-sm
                    hover:bg-gray-800 transition focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Sign In to Admin Panel
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-6">
                Not an admin?
                <a href="{{ route('login') }}" class="text-blue-700 font-semibold hover:underline">
                    Voter login here
                </a>
            </p>

        </div>
    </div>

</body>
</html>