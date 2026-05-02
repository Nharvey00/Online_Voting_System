<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply as Candidate — VoteSystem</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">

    @include('voter.partials.navbar')

    <div class="max-w-2xl mx-auto px-6 py-8">

        {{-- Header --}}
        <div class="mb-7">
            <a href="{{ route('voter.dashboard') }}"
                class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 mb-4 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Dashboard
            </a>
            <h1 class="text-2xl font-extrabold text-gray-900">Apply as Candidate</h1>
            <p class="text-gray-500 text-sm mt-1">
                {{ $election->title }}
                <span class="ml-2 inline-flex items-center gap-1 text-xs font-semibold bg-green-50 text-green-700 border border-green-200 px-2 py-0.5 rounded-full">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                    {{ ucfirst($election->status) }}
                </span>
            </p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-5 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('candidate.apply.store') }}"
            enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Position --}}
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Position</h3>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Running For</label>
                    <select name="position_id" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white">
                        <option value="">Select a position</option>
                        @foreach($positions as $position)
                            <option value="{{ $position->id }}"
                                {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                {{ $position->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('position_id') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Platform --}}
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Platform</h3>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Platform / Bio
                        <span class="text-gray-400 font-normal text-xs ml-1">Minimum 50 characters</span>
                    </label>
                    <textarea name="platform" rows="6" required
                        placeholder="Tell voters why you should be elected. Describe your platform, goals, and qualifications..."
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm
                        focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white resize-none">{{ old('platform') }}</textarea>
                    @error('platform') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Document --}}
            <div class="bg-white border border-gray-200 rounded-lg p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Supporting Document</h3>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Upload Document
                        <span class="text-gray-400 font-normal text-xs ml-1">PDF, JPG, PNG — max 4MB</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-2">
                        e.g. certificate of eligibility, endorsement letter, or any supporting document.
                    </p>
                    <input type="file" name="document" accept=".pdf,.jpg,.jpeg,.png" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm bg-white
                        file:mr-3 file:py-1 file:px-3 file:rounded file:border-0
                        file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100">
                    @error('document') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Notice --}}
            <div class="bg-blue-50 border border-blue-100 rounded-lg p-4">
                <p class="text-sm text-blue-700">
                    <span class="font-semibold">Note:</span>
                    Your application will be reviewed by the admin before you appear on the ballot.
                    You will only be allowed to apply once per election.
                </p>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-blue-700 text-white py-2.5 rounded-lg font-bold text-sm hover:bg-blue-800 transition">
                    Submit Application
                </button>
                <a href="{{ route('voter.dashboard') }}"
                    class="px-6 py-2.5 border border-gray-200 text-gray-600 rounded-lg font-semibold text-sm hover:bg-gray-50 transition">
                    Cancel
                </a>
            </div>

        </form>
    </div>

</body>
</html>