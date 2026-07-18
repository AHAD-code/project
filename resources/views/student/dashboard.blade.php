<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PEL InternSpace | Student Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background-color: #334155; border-radius: 10px; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-slate-50 text-gray-900" x-data="{ sidebarOpen: true, taskModalOpen: false, selectedTaskId: null, selectedTaskTitle: '' }">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="bg-pel-dark text-slate-300 transition-all duration-300 border-r border-slate-800 flex flex-col z-20" :class="sidebarOpen ? 'w-64' : 'w-20'">
            <div class="h-20 shrink-0 flex items-center justify-between px-4 border-b border-slate-700/50">
                <div class="flex items-center gap-2" x-show="sidebarOpen">
                    <div class="bg-pel-blue text-white font-bold text-xl px-2 py-1 rounded-sm tracking-widest shadow-sm">PEL</div>
                    <span class="font-medium text-sm text-slate-400">InternSpace</span>
                </div>
                <div class="bg-pel-blue text-white font-bold text-xl px-2 py-1 rounded-sm tracking-widest mx-auto" x-show="!sidebarOpen">P</div>
                <button @click="sidebarOpen = !sidebarOpen" class="text-slate-400 hover:text-white transition-colors" x-show="sidebarOpen">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>

            <nav class="flex-1 py-6 px-3 space-y-2 overflow-y-auto custom-scrollbar">
                <a href="#" class="flex items-center px-3 py-3 rounded-xl bg-pel-blue/10 text-pel-blue border border-pel-blue/20">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen">My Dashboard</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-700/50 mt-auto shrink-0">
                <form method="POST" action="{{ route('logout') ?? '#' }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-3 py-3 rounded-xl text-red-400 hover:bg-red-500/10 transition-all group overflow-hidden">
                        <svg class="w-5 h-5 shrink-0 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span class="ml-3 font-medium whitespace-nowrap" x-show="sidebarOpen">Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 md:p-8 relative">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-gray-200 pb-6">
                <div>
                    <p class="text-sm font-semibold text-pel-blue uppercase tracking-wider mb-1">Internship Program 2026</p>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Welcome back, {{ explode(' ', $intern->name)[0] }}!</h1>
                    <p class="text-gray-500 mt-1 text-sm">Here is your real-time performance summary and metrics tracker.</p>
                </div>
                <div class="flex items-center gap-4 bg-white px-4 py-2 rounded-full shadow-sm border border-gray-100">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-semibold text-gray-900">{{ $intern->name }}</p>
                        <p class="text-xs text-pel-blue font-medium">{{ $intern->registration_number }}</p>
                    </div>
                    <img class="w-10 h-10 rounded-full border-2 border-slate-100" src="https://ui-avatars.com/api/?name={{ urlencode($intern->name) }}&background=005a9c&color=fff" alt="Profile">
                </div>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- LEFT COLUMN -->
                <div class="lg:col-span-2 space-y-8">

                    <!-- Tasks Module -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-slate-50 px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">Assigned Production Tasks</h2>
                                <p class="text-xs text-gray-500 mt-1">Live task assignments</p>
                            </div>
                            <span class="bg-pel-blue/10 text-pel-blue text-xs font-bold px-3 py-1 rounded-full">{{ $tasks->count() }} Records Found</span>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-500 uppercase bg-white border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 font-semibold">Task Details</th>
                                        <th class="px-6 py-4 font-semibold">Status</th>
                                        <th class="px-6 py-4 font-semibold text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($tasks as $task)
                                        <tr class="hover:bg-slate-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <p class="font-medium text-gray-900">{{ $task->title }}</p>
                                                <p class="text-xs text-gray-500 max-w-sm truncate">{{ $task->description }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($task->status == 'Completed')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">Completed</span>
                                                @elseif($task->status == 'In Progress')
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">In Progress</span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700 border border-slate-200">Pending</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                @if($task->status != 'Completed')
                                                    <button @click="taskModalOpen = true; selectedTaskId = {{ $task->id }}; selectedTaskTitle = '{{ addslashes($task->title) }}'" class="text-pel-blue hover:text-blue-800 font-medium text-xs border border-pel-blue/20 px-3 py-1 rounded">Update</button>
                                                @else
                                                    <button class="text-gray-400 font-medium text-xs cursor-not-allowed" disabled>Locked</button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-8 text-center text-gray-500">
                                                <p class="text-sm">No verification entries map to this specific user identification criteria.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Weekly Attendance Log -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-slate-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h2 class="text-lg font-bold text-gray-900">Real-Time Logged Attendance</h2>
                            <span class="text-xs font-medium text-gray-500">Weekly Summary</span>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri'] as $day)
                                    @if(isset($attendances[$day]))
                                        <div class="border border-green-100 rounded-xl p-4 text-center bg-green-50/30 shadow-sm">
                                            <p class="text-xs text-gray-500 font-medium mb-1">{{ $day }}</p>
                                            <div class="w-8 h-8 mx-auto bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                            <p class="text-xs font-bold text-gray-900">{{ \Carbon\Carbon::parse($attendances[$day]->created_at)->format('h:i A') }}</p>
                                        </div>
                                    @elseif($day === now()->format('D'))
                                        <div class="border-2 border-pel-blue rounded-xl p-4 text-center bg-blue-50/30 shadow-sm relative">
                                            <span class="absolute -top-2 -right-2 flex h-3 w-3">
                                              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-pel-blue opacity-75"></span>
                                              <span class="relative inline-flex rounded-full h-3 w-3 bg-pel-blue"></span>
                                            </span>
                                            <p class="text-xs text-pel-blue font-bold mb-2">Today</p>
                                            <form action="#" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full bg-pel-blue text-white text-xs font-bold py-2 rounded-lg hover:bg-blue-800 transition shadow-sm">
                                                    Check In
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="border border-gray-100 rounded-xl p-4 text-center bg-gray-50 flex flex-col justify-center items-center opacity-60">
                                            <p class="text-xs text-gray-400 font-medium mb-1">{{ $day }}</p>
                                            <div class="w-8 h-8 mx-auto bg-gray-200 text-gray-400 rounded-full flex items-center justify-center mb-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="text-[10px] uppercase font-bold text-gray-400">-</p>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div class="space-y-8">
                    <!-- Intern Profile Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="h-24 bg-gradient-to-r from-slate-800 to-pel-dark"></div>
                        <div class="px-6 pb-6 relative">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($intern->name) }}&background=f8fafc&color=0f172a&size=128" alt="Profile" class="w-20 h-20 rounded-xl border-4 border-white shadow-md absolute -top-10 bg-white">
                            <div class="pt-12">
                                <h3 class="text-xl font-bold text-gray-900">{{ $intern->name }}</h3>
                                <p class="text-sm font-medium text-pel-blue">{{ $intern->department }}</p>
                                <div class="mt-6 space-y-4">
                                    <div>
                                        <label class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide block">University Assignment</label>
                                        <p class="text-sm font-medium text-gray-800">{{ $intern->university }}</p>
                                    </div>
                                    <div>
                                        <label class="text-[10px] font-semibold text-gray-400 uppercase tracking-wide block">Database Registration Reference</label>
                                        <p class="text-sm font-medium text-gray-800 font-mono bg-gray-50 px-2 py-1 rounded inline-block mt-1 border border-gray-100">{{ $intern->registration_number }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Supervisor Info Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wider flex items-center gap-2">Reporting To</h3>
                        @if($supervisor)
                            <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-gray-100">
                                <div class="w-12 h-12 rounded-full bg-pel-blue text-white flex items-center justify-center font-bold text-lg shadow-sm">
                                    {{ substr($supervisor->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900">{{ $supervisor->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $supervisor->designation ?? 'Lead Supervisor' }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-4 text-sm text-gray-500 bg-gray-50 rounded-lg border border-gray-100">
                                No tracking supervisor linked to profile.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </main>

        <!-- Task Update Modal -->
        <div x-show="taskModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" @keydown.escape.window="taskModalOpen = false">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 overflow-hidden" @click.away="taskModalOpen = false">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-900">Update Assigned Task</h3>
                        <button @click="taskModalOpen = false" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                    </div>

                    <p class="text-sm text-gray-500 mb-4">Task Context: <span class="font-semibold text-gray-900" x-text="selectedTaskTitle"></span></p>

                    <form method="POST" :action="'/tasks/' + selectedTaskId + '/update'" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status Designation</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm text-sm p-2 border focus:border-pel-blue focus:ring-1 focus:ring-pel-blue">
                                <option value="In Progress">In Progress</option>
                                <option value="Completed">Ready for Review</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Upload Submit Document (ZIP/PDF)</label>
                            <input type="file" name="task_file" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-pel-blue/10 file:text-pel-blue hover:file:bg-pel-blue/20">
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" @click="taskModalOpen = false" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Cancel</button>
                            <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-pel-blue hover:bg-blue-800 rounded-lg shadow-sm">Save Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
