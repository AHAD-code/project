<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEL InternSpace | Weekly Applications Report</title>
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
                            accent: '#e0f2fe'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-50 text-gray-900 font-sans">

    <div class="flex h-screen overflow-hidden">

        <!-- Supervisor Sidebar -->
        <aside class="w-64 bg-pel-dark text-slate-300 flex flex-col z-20 hidden md:flex border-r border-slate-800">
            <div class="h-20 flex items-center gap-2 px-6 border-b border-slate-700/50">
                <div class="bg-pel-blue text-white font-bold text-xl px-2 py-1 rounded-sm shadow-sm">PEL</div>
                <span class="font-medium text-sm text-slate-400">Supervisor Hub</span>
            </div>
            <nav class="flex-1 py-6 px-3 space-y-2">
                <a href="{{ route('supervisor.dashboard') }}" class="flex items-center px-3 py-3 rounded-xl hover:bg-white/5 transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="ml-3">Dashboard</span>
                </a>
                <a href="#" class="flex items-center px-3 py-3 rounded-xl bg-pel-blue/10 text-pel-blue border border-pel-blue/20">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="ml-3 font-medium">Weekly Reports</span>
                </a>
            </nav>
            <div class="p-4 border-t border-slate-700/50 mt-auto">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-3 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="ml-3 font-medium">Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 relative">

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200 shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <header class="mb-8 border-b border-gray-200 pb-6 flex flex-col md:flex-row justify-between items-start md:items-end gap-4">
                <div>
                    <p class="text-sm font-semibold text-pel-blue uppercase tracking-wider mb-1">Applications & Data</p>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Weekly Student Report</h1>
                    <p class="text-gray-500 mt-1 text-sm">Reviewing intern applications submitted during the current working week.</p>
                </div>
                <div class="bg-white px-5 py-3 border border-gray-100 rounded-xl shadow-sm text-sm font-medium text-gray-600 flex items-center gap-3">
                    <svg class="w-8 h-8 text-pel-blue/20" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Total Submissions</p>
                        <p class="text-pel-blue font-bold text-xl leading-none mt-1">{{ collect($applications)->count() }}</p>
                    </div>
                </div>
            </header>

            <!-- Data Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left whitespace-nowrap">
                        <thead class="text-xs text-gray-500 uppercase bg-slate-50 border-b border-gray-100">
                            <tr>
                                <th class="px-6 py-4 font-semibold">Applicant Profile</th>
                                <th class="px-6 py-4 font-semibold">Academic Info</th>
                                <th class="px-6 py-4 font-semibold">Submission Date</th>
                                <th class="px-6 py-4 font-semibold">Status</th>
                                <th class="px-6 py-4 font-semibold text-right">Attached Resume</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($applications ?? [] as $app)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-pel-blue text-white flex items-center justify-center font-bold text-xs shadow-sm">
                                                {{ substr($app->name ?? '', 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900">{{ $app->name ?? 'N/A' }}</p>
                                                <p class="text-xs text-gray-500">{{ $app->email ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="font-medium text-gray-800">{{ $app->university ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500 font-mono mt-0.5">{{ $app->department ?? 'N/A' }} | {{ $app->registration_number ?? 'N/A' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-gray-700 font-medium">{{ $app->created_at ? \Carbon\Carbon::parse($app->created_at)->format('M d, Y') : 'N/A' }}</p>
                                        <p class="text-xs text-gray-400">{{ $app->created_at ? \Carbon\Carbon::parse($app->created_at)->format('h:i A') : 'N/A' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider bg-yellow-50 text-yellow-700 border border-yellow-200">
                                            {{ $app->status ?? 'Pending' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($app && $app->cv_path)
                                            <a href="{{ route('supervisor.reports.download-cv', $app->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-pel-blue text-white text-xs font-bold rounded-lg hover:bg-blue-800 transition-colors shadow-sm focus:ring-2 focus:ring-offset-2 focus:ring-pel-blue">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                Download CV
                                            </a>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-xs text-red-500 font-medium px-3 py-1.5 bg-red-50 rounded border border-red-100">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Missing File
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-16 text-center text-gray-500 bg-slate-50/50">
                                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="font-medium text-gray-600">No applications on file.</p>
                                        <p class="text-xs mt-1 text-gray-400">There are no new student applications matching this week's timeframe.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
