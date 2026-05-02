<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elections — VoteSystem Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex">

    @include('admin.partials.sidebar')

    <div class="flex-1 flex flex-col min-w-0">

        <div class="bg-white border-b border-gray-200 px-8 py-4 flex items-center justify-between">
            <div>
                <h1 class="text-xl font-extrabold text-gray-900">Elections</h1>
                <p class="text-gray-400 text-sm mt-0.5">Create and manage elections</p>
            </div>
            <a href="{{ route('admin.elections.create') }}"
                class="px-4 py-2 bg-blue-700 text-white text-sm font-bold rounded-lg hover:bg-blue-800 transition">
                New Election
            </a>
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
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Election</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Start</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">End</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Status</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Results</th>
                            <th class="px-6 py-3.5 text-left text-xs font-bold text-gray-500 uppercase tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($elections as $election)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900">{{ $election->title }}</p>
                                @if($election->description)
                                    <p class="text-gray-400 text-xs mt-0.5 truncate max-w-xs">{{ $election->description }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $election->start_at->format('M d, Y h:i A') }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $election->end_at->format('M d, Y h:i A') }}</td>
                            <td class="px-6 py-4">
                                @if($election->isDraft())
                                    <span class="inline-flex items-center gap-1 bg-amber-50 text-amber-700 border border-amber-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                                        Draft
                                    </span>
                                @elseif($election->isOngoing())
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span>
                                        Ongoing
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 border border-gray-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                        <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                                        Closed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($election->results_published)
                                    <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-semibold">
                                        Published
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">Not published</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2 flex-wrap">

                                    <a href="{{ route('admin.positions.index', $election) }}"
                                        class="text-xs font-semibold text-blue-700 hover:underline">
                                        Positions
                                    </a>

                                    @if(!$election->isClosed())
                                        <span class="text-gray-200">|</span>
                                        <a href="{{ route('admin.elections.edit', $election) }}"
                                            class="text-xs font-semibold text-gray-600 hover:underline">
                                            Edit
                                        </a>
                                    @endif

                                    @if($election->isDraft())
                                        <span class="text-gray-200">|</span>
                                        <form method="POST" action="{{ route('admin.elections.updateStatus', $election) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="ongoing">
                                            <button type="submit"
                                                onclick="return confirm('Start this election? Make sure all positions and candidates are set.')"
                                                class="text-xs font-semibold text-green-600 hover:underline">
                                                Start
                                            </button>
                                        </form>
                                    @endif

                                    @if($election->isOngoing())
                                        <span class="text-gray-200">|</span>
                                        <form method="POST" action="{{ route('admin.elections.updateStatus', $election) }}">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="closed">
                                            <button type="submit"
                                                onclick="return confirm('Close this election? Voting will stop immediately.')"
                                                class="text-xs font-semibold text-red-600 hover:underline">
                                                Close
                                            </button>
                                        </form>
                                    @endif

                                    @if($election->isClosed() && !$election->results_published)
                                        <span class="text-gray-200">|</span>
                                        <form method="POST" action="{{ route('admin.elections.publish', $election) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                onclick="return confirm('Publish the final results? This cannot be undone.')"
                                                class="text-xs font-semibold text-purple-600 hover:underline">
                                                Publish Results
                                            </button>
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-14 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-500 font-medium text-sm">No elections yet</p>
                                <p class="text-gray-400 text-xs mt-1">Create your first election to get started</p>
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