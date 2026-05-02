<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex bg-white">

    {{-- Left Branding --}}
    <div class="hidden lg:flex w-5/12 bg-blue-700 flex-col justify-between p-12 relative overflow-hidden">

        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute top-[-100px] left-[-100px] w-96 h-96 bg-blue-600 rounded-full opacity-30"></div>
            <div class="absolute bottom-[-80px] right-[-80px] w-80 h-80 bg-blue-800 rounded-full opacity-30"></div>
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
                Register to make your voice heard.
            </h2>
            <p class="text-blue-200 text-base leading-relaxed mb-10">
                Create your voter account to participate in elections, apply as a candidate, and track results.
            </p>

            <div class="space-y-5">
                @foreach([
                    ['01', 'Personal Details', 'Provide your full name, birthdate and address.'],
                    ['02', 'Valid ID', 'Submit a government-issued ID for verification.'],
                    ['03', 'Start Voting', 'Access active elections and cast your vote.'],
                ] as $step)
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 bg-blue-600 border border-blue-400 rounded-lg flex items-center justify-center flex-shrink-0 font-bold text-white text-xs">
                        {{ $step[0] }}
                    </div>
                    <div>
                        <p class="text-white text-sm font-semibold">{{ $step[1] }}</p>
                        <p class="text-blue-200 text-xs mt-0.5">{{ $step[2] }}</p>
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
    <div class="w-full lg:w-7/12 flex items-start justify-center px-8 py-10 bg-gray-50 overflow-y-auto">
        <div class="w-full max-w-xl">

            <div class="mb-7">
                <h1 class="text-3xl font-extrabold text-gray-900">Create Account</h1>
                <p class="text-gray-500 text-sm mt-2">Fill in all fields to register as a voter</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}"
                enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Account Information --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                        Account Information
                    </h3>
                    <div class="space-y-4">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                placeholder="Juan Dela Cruz"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                placeholder="juan@example.com"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                                <input type="password" name="password" required
                                    placeholder="Min. 8 characters"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirm Password</label>
                                <input type="password" name="password_confirmation" required
                                    placeholder="Repeat password"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Personal Information --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                        Personal Information
                    </h3>
                    <div class="space-y-4">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Birthdate
                                <span class="text-gray-400 font-normal text-xs ml-1">Must be 18 or older</span>
                            </label>
                            <input type="date" name="birthdate" value="{{ old('birthdate') }}" required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                            @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Street Address</label>
                            <input type="text" name="address" value="{{ old('address') }}" required
                                placeholder="House No., Street Name"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                            @error('address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Barangay</label>
                                <input type="text" name="barangay" value="{{ old('barangay') }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                @error('barangay') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">City</label>
                                <input type="text" name="city" value="{{ old('city') }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Province</label>
                                <input type="text" name="province" value="{{ old('province') }}" required
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                @error('province') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                    </div>
                </div>

                {{-- ID Credentials --}}
                <div class="bg-white border border-gray-200 rounded-lg p-5">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                        ID Credentials
                    </h3>
                    <div class="space-y-4">

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">ID Type</label>
                                <select name="id_type" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                    <option value="">Select ID Type</option>
                                    @foreach(['PhilSys', 'Passport', 'Drivers License', 'UMID', 'PRC ID', 'Postal ID', 'Senior Citizen ID', 'PWD ID', 'Voter ID'] as $idType)
                                        <option value="{{ $idType }}" {{ old('id_type') == $idType ? 'selected' : '' }}>
                                            {{ $idType }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">ID Number</label>
                                <input type="text" name="id_number" value="{{ old('id_number') }}" required
                                    placeholder="Enter ID number"
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                @error('id_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    ID Photo
                                    <span class="text-gray-400 font-normal text-xs ml-1">JPG/PNG, max 2MB</span>
                                </label>
                                <input type="file" name="id_photo" accept="image/*" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm bg-white
                                    file:mr-3 file:py-1 file:px-3 file:rounded file:border-0
                                    file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100">
                                @error('id_photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                    Profile Photo
                                    <span class="text-gray-400 font-normal text-xs ml-1">JPG/PNG, max 2MB</span>
                                </label>
                                <input type="file" name="profile_photo" accept="image/*" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm bg-white
                                    file:mr-3 file:py-1 file:px-3 file:rounded file:border-0
                                    file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700
                                    hover:file:bg-blue-100">
                                @error('profile_photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-700 text-white py-3 rounded-lg font-bold text-sm
                    hover:bg-blue-800 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Create My Voter Account
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-5 pb-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-blue-700 font-semibold hover:underline">
                    Sign in here
                </a>
            </p>

        </div>
    </div>

</body>
</html>