<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positions — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <div>
                <a href="{{ route('admin.elections.index') }}"
                    class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-1 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Back to Elections
                </a>
                <div class="flex items-center gap-3">
                    <h1 class="text-xl font-extrabold text-gray-900">Positions</h1>
                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-full border
                        {{ $election->isDraft() ? 'bg-amber-50 text-amber-700 border-amber-200' : ($election->isOngoing() ? 'bg-green-50 text-green-700 border-green-200' : 'bg-gray-100 text-gray-500 border-gray-200') }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $election->isDraft() ? 'bg-amber-500' : ($election->isOngoing() ? 'bg-green-500 animate-pulse' : 'bg-gray-400') }}"></span>
                        {{ ucfirst($election->status) }}
                    </span>
                </div>
                <p class="text-gray-400 text-sm mt-0.5">{{ $election->title }}</p>
            </div>
            @if(!$election->isClosed())
                <a href="{{ route('admin.positions.create', $election) }}"
                    class="px-4 py-2 bg-blue-700 text-white text-sm font-bold rounded-lg hover:bg-blue-800 transition">
                    Add Position
                </a>
            @endif
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

            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Order</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Position Name</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Max Winners</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Approved Candidates</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($positions as $position)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="w-7 h-7 bg-gray-100 rounded-lg flex items-center justify-center text-xs font-bold text-gray-600">
                                    {{ $position->order }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-gray-900">{{ $position->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $position->max_winners }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                    {{ $position->candidates()->where('status', 'approved')->count() }} approved
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if(!$election->isClosed())
                                        <a href="{{ route('admin.positions.edit', [$election, $position]) }}"
                                            class="text-xs font-semibold text-blue-700 hover:underline">Edit</a>
                                    @endif
                                    @if($election->isDraft())
                                        <span class="text-gray-200">|</span>
                                        <form method="POST" action="{{ route('admin.positions.destroy', [$election, $position]) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Delete this position?')"
                                                class="text-xs font-semibold text-red-600 hover:underline">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-14 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">No positions added yet</p>
                                <p class="text-gray-400 text-xs mt-1">Add positions voters will vote for</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>

</body>
</html>