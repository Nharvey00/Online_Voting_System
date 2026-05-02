<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Election — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <div class="bg-white border-b border-gray-200 px-8 py-4">
            <a href="{{ route('admin.elections.index') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Elections
            </a>
            <h1 class="text-xl font-extrabold text-gray-900">Create Election</h1>
        </div>

        <main class="flex-1 p-8">

            @if($hasActive)
                <div class="bg-amber-50 border border-amber-200 text-amber-800 px-5 py-4 rounded-lg mb-6 text-sm">
                    <p class="font-bold">Cannot create a new election</p>
                    <p class="mt-1">There is already an active election. Close it before creating a new one.</p>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="max-w-2xl">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <form method="POST" action="{{ route('admin.elections.store') }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Election Title</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                placeholder="e.g. Student Government Election 2025"
                                {{ $hasActive ? 'disabled' : '' }} required
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                bg-white disabled:bg-gray-100 disabled:text-gray-400">
                            @error('title') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Description
                                <span class="text-gray-400 font-normal text-xs ml-1">Optional</span>
                            </label>
                            <textarea name="description" rows="3"
                                placeholder="Brief description of this election..."
                                {{ $hasActive ? 'disabled' : '' }}
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                bg-white resize-none disabled:bg-gray-100 disabled:text-gray-400">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Start Date & Time</label>
                                <input type="datetime-local" name="start_at" value="{{ old('start_at') }}"
                                    {{ $hasActive ? 'disabled' : '' }} required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                    bg-white disabled:bg-gray-100 disabled:text-gray-400">
                                @error('start_at') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">End Date & Time</label>
                                <input type="datetime-local" name="end_at" value="{{ old('end_at') }}"
                                    {{ $hasActive ? 'disabled' : '' }} required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                                    bg-white disabled:bg-gray-100 disabled:text-gray-400">
                                @error('end_at') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        @if(!$hasActive)
                        <div class="pt-2 flex gap-3">
                            <button type="submit"
                                class="px-6 py-2.5 bg-blue-700 text-white font-bold text-sm rounded-lg hover:bg-blue-800 transition">
                                Create Election
                            </button>
                            <a href="{{ route('admin.elections.index') }}"
                                class="px-6 py-2.5 border border-gray-200 text-gray-600 font-semibold text-sm rounded-lg hover:bg-gray-50 transition">
                                Cancel
                            </a>
                        </div>
                        @endif

                    </form>
                </div>
            </div>

        </main>
    </div>

</body>
</html>