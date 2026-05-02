<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results Pending — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md text-center">
        <div class="bg-white border border-gray-200 rounded-lg p-10 shadow-sm">

            <div class="w-14 h-14 bg-amber-50 border border-amber-100 rounded-lg flex items-center justify-center mx-auto mb-5">
                <svg class="w-7 h-7 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>

            <h1 class="text-xl font-extrabold text-gray-900 mb-2">Results Pending</h1>
            <p class="text-gray-500 text-sm leading-relaxed">
                The election <span class="font-semibold text-gray-700">{{ $election->title }}</span>
                has concluded. The admin will review and publish the final results shortly.
            </p>

            <div class="mt-6 pt-6 border-t border-gray-100">
                <a href="{{ route('voter.dashboard') }}"
                    class="inline-block bg-blue-700 text-white px-7 py-2.5 rounded-lg font-bold text-sm hover:bg-blue-800 transition">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>

</body>
</html>