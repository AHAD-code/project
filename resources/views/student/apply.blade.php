<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEL InternSpace | Apply</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        pel: {
                            blue: '#005a9c',
                            dark: '#0f172a',
                            light: '#f8fafc',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-gray-900 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-2xl w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        <!-- Header -->
        <div class="bg-pel-dark p-8 text-center relative">
            <div class="absolute top-4 right-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-slate-400 hover:text-white transition">Sign Out</button>
                </form>
            </div>
            <div class="bg-pel-blue text-white font-bold text-2xl px-4 py-2 rounded-md tracking-widest inline-block shadow-md mb-4">PEL</div>
            <h1 class="text-2xl font-bold text-white">Internship Application Portal</h1>
            <p class="text-slate-400 mt-2 text-sm">Please complete your profile to access the dashboard.</p>
        </div>

        <!-- Form -->
        <div class="p-8">

            <!-- Global Error Display -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-lg text-sm">
                    <strong class="font-bold">Please fix the following errors:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Action Updated to Point to Your Controller -->
            <form action="{{ route('student.apply.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name (Read-only from login) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input type="text" value="{{ $user->name }}" readonly class="w-full bg-gray-50 border-gray-200 rounded-lg shadow-sm text-sm p-3 text-gray-500 cursor-not-allowed border">
                    </div>

                    <!-- Email (Read-only from login) -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" value="{{ $user->email }}" readonly class="w-full bg-gray-50 border-gray-200 rounded-lg shadow-sm text-sm p-3 text-gray-500 cursor-not-allowed border">
                    </div>

                    <!-- University -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">University</label>
                        <input type="text" name="university" value="{{ old('university') }}" required placeholder="e.g. COMSATS University" class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-3 border focus:border-pel-blue focus:ring-1 focus:ring-pel-blue outline-none @error('university') border-red-500 @enderror">
                        @error('university') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Department</label>
                        <input type="text" name="department" value="{{ old('department') }}" required placeholder="e.g. Computer Science" class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-3 border focus:border-pel-blue focus:ring-1 focus:ring-pel-blue outline-none @error('department') border-red-500 @enderror">
                        @error('department') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Registration Number -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Registration / Roll Number</label>
                        <input type="text" name="registration_number" value="{{ old('registration_number') }}" required placeholder="e.g. FA23-1234" class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-3 border focus:border-pel-blue focus:ring-1 focus:ring-pel-blue outline-none @error('registration_number') border-red-500 @enderror">
                        @error('registration_number') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- CV Upload -->
                <div class="mt-6 p-6 border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 text-center @error('cv_file') border-red-500 bg-red-50 @enderror">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload your CV / Resume</label>
                    <input type="file" name="cv_file" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-pel-blue/10 file:text-pel-blue hover:file:bg-pel-blue/20 cursor-pointer">
                    <p class="text-xs text-gray-400 mt-2">PDF, DOCX, or ZIP up to 5MB</p>
                    @error('cv_file') <span class="text-xs text-red-500 mt-2 block font-medium">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-pel-blue text-white font-bold text-sm py-3 rounded-xl hover:bg-blue-800 transition-colors shadow-md mt-4">
                    Submit Application
                </button>
            </form>
        </div>
    </div>

</body>
</html>
