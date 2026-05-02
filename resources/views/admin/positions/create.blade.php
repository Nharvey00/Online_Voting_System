<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Position — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <div class="bg-white border-b border-gray-200 px-8 py-4">
            <a href="{{ route('admin.positions.index', $election) }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-1 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Positions
            </a>
            <h1 class="text-xl font-extrabold text-gray-900">Add Position</h1>
            <p class="text-gray-400 text-sm mt-0.5">{{ $election->title }}</p>
        </div>

        <main class="flex-1 p-8">

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="max-w-xl">
                <div class="bg-white border border-gray-200 rounded-lg p-6">
                    <form method="POST" action="{{ route('admin.positions.store', $election) }}" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Position Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" required
                                placeholder="e.g. President, Vice President, Secretary"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                            @error('name') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Max Winners</label>
                                <input type="number" name="max_winners" value="{{ old('max_winners', 1) }}" min="1" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                <p class="text-gray-400 text-xs mt-1">Usually 1. Set higher for multi-winner positions.</p>
                                @error('max_winners') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Display Order</label>
                                <input type="number" name="order" value="{{ old('order', 0) }}" min="0" required
                                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                                    focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                                <p class="text-gray-400 text-xs mt-1">Lower = shown first on ballot.</p>
                                @error('order') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-2 flex gap-3">
                            <button type="submit"
                                class="px-6 py-2.5 bg-blue-700 text-white font-bold text-sm rounded-lg hover:bg-blue-800 transition">
                                Add Position
                            </button>
                            <a href="{{ route('admin.positions.index', $election) }}"
                                class="px-6 py-2.5 border border-gray-200 text-gray-600 font-semibold text-sm rounded-lg hover:bg-gray-50 transition">
                                Cancel
                            </a>
                        </div>

                    </form>
                </div>
            </div>

        </main>
    </div>

</body>
</html>