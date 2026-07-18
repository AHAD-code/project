<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard | PEL IMS</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            /* PEL Corporate Colors */
            --pel-blue: #0A3A82;
            --pel-dark-blue: #062352;
            --pel-red: #D32F2F;
            --bg-light: #f4f6f9;
            --text-dark: #2c3e50;
            --text-muted: #8392a5;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ----- Sidebar Styles ----- */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            background: var(--pel-dark-blue);
            background: linear-gradient(180deg, var(--pel-dark-blue) 0%, var(--pel-blue) 100%);
            color: #d1d5db;
            z-index: 1040;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar-brand {
            padding: 20px 24px;
            background: rgba(0,0,0,0.15);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .pel-logo {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: 2px;
            color: #ffffff;
            text-shadow: 2px 2px 0px var(--pel-red);
        }

        .sidebar .nav-link {
            color: #cbd5e1;
            padding: 12px 20px;
            margin: 4px 16px;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link i {
            width: 30px;
            font-size: 1.1rem;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: #ffffff;
            transform: translateX(5px);
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 20px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        /* ----- Main Content ----- */
        .main-content {
            margin-left: 280px;
            padding: 30px;
            transition: margin-left 0.3s ease;
        }

        /* ----- Top Navbar ----- */
        .top-navbar {
            background: white;
            border-radius: 12px;
            padding: 12px 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: var(--pel-blue);
            cursor: pointer;
        }

        /* ----- Cards & UI Elements ----- */
        .stat-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
            overflow: hidden;
            position: relative;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 4px;
            background: var(--pel-blue);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.08);
        }
        .stat-card:hover::before { opacity: 1; }

        .icon-box {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        /* ----- Intern Cards ----- */
        .intern-card {
            border: 1px solid rgba(0,0,0,0.05);
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            transition: all 0.3s ease;
            background: #fff;
        }

        .intern-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            border-color: var(--pel-blue);
        }

        .intern-avatar {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .intern-card:hover .intern-avatar {
            transform: scale(1.05);
        }

        .btn-pel {
            background-color: var(--pel-blue);
            color: #fff;
            transition: all 0.2s;
        }
        .btn-pel:hover {
            background-color: var(--pel-dark-blue);
            color: #fff;
            box-shadow: 0 4px 10px rgba(10, 58, 130, 0.3);
        }

        /* ----- Modals ----- */
        .modal-content {
            border-radius: 16px;
            border: none;
        }
        .modal-header {
            background: var(--bg-light);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            border-radius: 16px 16px 0 0;
        }

        .detail-row {
            padding: 12px 0;
            border-bottom: 1px dashed #e2e8f0;
        }
        .detail-row:last-child { border-bottom: none; }

        /* ----- Responsive Media Queries ----- */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .menu-toggle { display: block; }
        }
    </style>
</head>
<body>

    <!-- OVERLAY FOR MOBILE -->
    <div id="sidebarOverlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark opacity-50 d-none" style="z-index: 1030;"></div>

    <!-- SIDEBAR -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-brand d-flex align-items-center">
            <div class="pel-logo me-2">PEL</div>
            <div class="ms-2 border-start border-light ps-2 border-opacity-25" style="line-height: 1.1;">
                <span class="d-block text-white fw-bold" style="font-size: 14px;">Supervisor</span>
                <span class="d-block text-white-50" style="font-size: 11px;">IMS Portal</span>
            </div>
        </div>

        <div class="pt-4 flex-grow-1">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="{{ route('supervisor.dashboard') }}" class="nav-link {{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i> My Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('supervisor.interns*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Assigned Interns
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('supervisor.tasks') ? 'active' : '' }}">
                        <i class="fas fa-tasks"></i> Task Board
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link {{ request()->routeIs('supervisor.attendance') ? 'active' : '' }}">
                        <i class="fas fa-chart-line"></i> Reports & Analytics
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logout Section in Sidebar -->
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST" class="d-grid">
                @csrf
                <button type="submit" class="btn btn-danger text-start px-3 py-2 fw-medium rounded-3" style="background: rgba(211, 47, 47, 0.9); border: none;">
                    <i class="fas fa-sign-out-alt me-2"></i> Secure Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- TOP NAVBAR -->
        <header class="top-navbar">
            <div class="d-flex align-items-center gap-3">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h4 class="mb-0 fw-bold text-dark" style="letter-spacing: -0.5px;">Welcome back, {{ $supervisor->name ?? 'Supervisor' }}</h4>
                    <p class="text-muted mb-0 small">Here is the latest update for your department.</p>
                </div>
            </div>

            <div class="d-flex align-items-center gap-4">
                <form action="" method="GET" class="d-none d-md-block">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted rounded-start-pill ps-3"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-0 rounded-end-pill" placeholder="Search interns or tasks...">
                    </div>
                </form>

                <!-- Notification Bell -->
                <div class="position-relative cursor-pointer">
                    <i class="fas fa-bell text-muted fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($supervisor->name ?? 'S') }}&background=0A3A82&color=fff" class="rounded-circle shadow-sm" width="45" alt="Profile">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2 rounded-3">
                        <li><a class="dropdown-item py-2" href="#"><i class="fas fa-user-cog me-2 text-muted"></i> Profile Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- ALERTS -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm d-flex align-items-center" role="alert">
                <i class="fas fa-check-circle fs-4 me-3"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- STATISTICS CARDS -->
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card h-100 p-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 12px;">Total Interns</p>
                            <h2 class="fw-bold mb-0 text-dark">{{ $stats['total_interns'] ?? 12 }}</h2>
                        </div>
                        <div class="icon-box" style="background: rgba(10, 58, 130, 0.1); color: var(--pel-blue);">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card h-100 p-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 12px;">Present Today</p>
                            <h2 class="fw-bold mb-0 text-dark">{{ $stats['present_today'] ?? 10 }}</h2>
                        </div>
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <i class="fas fa-user-check"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card h-100 p-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 12px;">Pending Tasks</p>
                            <h2 class="fw-bold mb-0 text-dark">{{ $stats['pending_tasks'] ?? 5 }}</h2>
                        </div>
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card stat-card h-100 p-2">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-semibold text-uppercase" style="font-size: 12px;">Avg Performance</p>
                            <h2 class="fw-bold mb-0 text-dark">87%</h2>
                        </div>
                        <div class="icon-box bg-info bg-opacity-10 text-info">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- INTERN CARDS GRID -->
            <div class="col-xl-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-dark">My Team Overview</h5>
                    <a href="#" class="btn btn-sm btn-light border text-muted fw-medium">View All</a>
                </div>

                <div class="row g-4">
                    @forelse($interns ?? [] as $intern)
                    <div class="col-md-6">
                        <div class="card intern-card h-100">
                            <div class="card-body text-center p-4">
                                <span class="badge bg-{{ $intern->status == 'Active' ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $intern->status == 'Active' ? 'success' : 'secondary' }} position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill fw-bold border">
                                    <i class="fas fa-circle ms-1" style="font-size: 8px; vertical-align: middle;"></i> {{ $intern->status }}
                                </span>

                                <img src="https://ui-avatars.com/api/?name={{ urlencode($intern->name) }}&background=f0f4f8&color=0A3A82" class="intern-avatar mb-3 mt-2">
                                <h5 class="fw-bold text-dark mb-1">{{ $intern->name }}</h5>
                                <p class="text-muted small mb-4"><i class="fas fa-briefcase me-1 text-opacity-50"></i> {{ $intern->department }}</p>

                                <div class="d-flex justify-content-around bg-light rounded-3 p-3 mb-4">
                                    <div>
                                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 10px;">Progress</small>
                                        <span class="fw-bold fs-5 text-dark">{{ $intern->progress ?? 0 }}%</span>
                                    </div>
                                    <div class="border-start border-2 border-white"></div>
                                    <div>
                                        <small class="text-muted d-block text-uppercase fw-semibold" style="font-size: 10px;">Tasks Done</small>
                                        <span class="fw-bold fs-5" style="color: var(--pel-blue);">{{ $intern->tasks_count ?? 0 }}</span>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <!-- Detail Modal Trigger -->
                                    <button class="btn btn-light border flex-grow-1 fw-medium" data-bs-toggle="modal" data-bs-target="#internDetailsModal{{ $intern->id }}">
                                        Details
                                    </button>
                                    <!-- Assign Task Modal Trigger -->
                                    <button class="btn btn-pel flex-grow-1 fw-medium shadow-sm" data-bs-toggle="modal" data-bs-target="#assignTaskModal{{ $intern->id }}">
                                        <i class="fas fa-plus me-1"></i> Task
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 1. FULL DETAILS MODAL FOR INTERN -->
                    <div class="modal fade" id="internDetailsModal{{ $intern->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow-lg">
                                <div class="modal-header">
                                    <h5 class="fw-bold mb-0"><i class="fas fa-id-badge text-primary me-2"></i> Intern Profile</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <div class="text-center mb-4">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($intern->name) }}&background=0A3A82&color=fff" class="intern-avatar mb-2" style="width:100px; height:100px;">
                                        <h4 class="fw-bold mb-0">{{ $intern->name }}</h4>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">{{ $intern->department }}</span>
                                    </div>
                                    <div class="card bg-light border-0">
                                        <div class="card-body">
                                            <div class="detail-row d-flex justify-content-between">
                                                <span class="text-muted fw-medium"><i class="fas fa-envelope me-2"></i> Email</span>
                                                <span class="text-dark fw-bold">{{ $intern->email ?? 'N/A' }}</span>
                                            </div>
                                            <div class="detail-row d-flex justify-content-between">
                                                <span class="text-muted fw-medium"><i class="fas fa-phone me-2"></i> Phone</span>
                                                <span class="text-dark fw-bold">{{ $intern->phone ?? '+92 300 0000000' }}</span>
                                            </div>
                                            <div class="detail-row d-flex justify-content-between">
                                                <span class="text-muted fw-medium"><i class="fas fa-university me-2"></i> University</span>
                                                <span class="text-dark fw-bold">{{ $intern->university ?? 'UET Lahore' }}</span>
                                            </div>
                                            <div class="detail-row d-flex justify-content-between">
                                                <span class="text-muted fw-medium"><i class="fas fa-calendar-alt me-2"></i> Join Date</span>
                                                <span class="text-dark fw-bold">{{ \Carbon\Carbon::parse($intern->created_at)->format('d M, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0 pb-4 pt-0 justify-content-center">
                                    <a href="#" class="btn btn-outline-primary rounded-pill px-4">View Full Report</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. ASSIGN TASK MODAL -->
                    <div class="modal fade" id="assignTaskModal{{ $intern->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow-lg">
                                <div class="modal-header">
                                    <h5 class="fw-bold mb-0">Assign Task: <span style="color: var(--pel-blue);">{{ $intern->name }}</span></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="/supervisor/assign-task" method="POST">
                                    @csrf
                                    <input type="hidden" name="intern_id" value="{{ $intern->id }}">
                                    <div class="modal-body p-4">
                                        <div class="mb-3">
                                            <label class="form-label text-dark fw-semibold">Task Title</label>
                                            <input type="text" name="title" class="form-control bg-light border-0 rounded-3 py-2" placeholder="e.g. Test PCB Board" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label text-dark fw-semibold">Description</label>
                                            <textarea name="description" class="form-control bg-light border-0 rounded-3" rows="3" placeholder="Provide clear instructions..."></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label class="form-label text-dark fw-semibold">Deadline</label>
                                                <input type="date" name="deadline" class="form-control bg-light border-0 rounded-3 py-2" required>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label text-dark fw-semibold">Priority</label>
                                                <select name="priority" class="form-select bg-light border-0 rounded-3 py-2">
                                                    <option value="Low">Low</option>
                                                    <option value="Medium" selected>Medium</option>
                                                    <option value="High" class="text-danger">High</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 bg-light rounded-bottom-4">
                                        <button type="button" class="btn btn-white border px-4" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-pel px-4">Confirm Task</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center py-5 border rounded-4 bg-white shadow-sm mt-2">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px; height:80px;">
                            <i class="fas fa-folder-open fs-2 text-muted"></i>
                        </div>
                        <h5 class="fw-bold text-dark">No Interns Assigned</h5>
                        <p class="text-muted">You currently do not have any interns in your supervision.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="mt-4 d-flex justify-content-end">
                    <!-- Ensure Bootstrap 5 pagination styling is published in your app -->
                    {{ method_exists($interns ?? [], 'links') ? $interns->links('pagination::bootstrap-5') : '' }}
                </div>
            </div>

            <!-- RIGHT COLUMN: Graph & Activities -->
            <div class="col-xl-4">

                <!-- ATTENDANCE GRAPH -->
                <div class="card stat-card mb-4 border border-light">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fw-bold mb-0">Weekly Attendance</h5>
                            <button class="btn btn-sm btn-light border"><i class="fas fa-download text-muted"></i></button>
                        </div>
                        <p class="text-muted small mb-4">Number of interns present over the last 7 days.</p>

                        <div style="height: 250px;">
                            <canvas id="attendanceChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- RECENT ACTIVITIES (Makes page longer & realistic) -->
                <div class="card stat-card border border-light">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Recent Activity</h5>

                        <div class="position-relative">
                            <!-- Timeline Line -->
                            <div class="position-absolute h-100 bg-light" style="width: 2px; left: 16px; top: 0;"></div>

                            <!-- Activity 1 -->
                            <div class="d-flex mb-4 position-relative">
                                <div class="bg-success rounded-circle d-flex align-items-center justify-content-center text-white z-1 shadow-sm mt-1" style="width:34px; height:34px; min-width:34px;">
                                    <i class="fas fa-check small"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0 text-dark fw-semibold text-sm">Ali Khan completed a task</p>
                                    <p class="mb-0 text-muted small">"PCB Board Diagnostics"</p>
                                    <small class="text-muted" style="font-size: 11px;">2 hours ago</small>
                                </div>
                            </div>
                            <!-- Activity 2 -->
                            <div class="d-flex mb-4 position-relative">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white z-1 shadow-sm mt-1" style="width:34px; height:34px; min-width:34px;">
                                    <i class="fas fa-tasks small"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0 text-dark fw-semibold text-sm">You assigned a new task</p>
                                    <p class="mb-0 text-muted small">To Sara Ahmed - "Market Survey"</p>
                                    <small class="text-muted" style="font-size: 11px;">Yesterday</small>
                                </div>
                            </div>
                            <!-- Activity 3 -->
                            <div class="d-flex position-relative">
                                <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center text-white z-1 shadow-sm mt-1" style="width:34px; height:34px; min-width:34px;">
                                    <i class="fas fa-exclamation-triangle small text-dark"></i>
                                </div>
                                <div class="ms-3">
                                    <p class="mb-0 text-dark fw-semibold text-sm">Missed Deadline</p>
                                    <p class="mb-0 text-muted small">Usman failed to submit report.</p>
                                    <small class="text-muted" style="font-size: 11px;">2 days ago</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Bootstrap & Chart.js Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // --- Sidebar Toggle Logic (Mobile Responsiveness) ---
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function toggleMenu() {
            sidebar.classList.toggle('active');
            if(sidebar.classList.contains('active')){
                overlay.classList.remove('d-none');
            } else {
                overlay.classList.add('d-none');
            }
        }

        menuToggle.addEventListener('click', toggleMenu);
        overlay.addEventListener('click', toggleMenu);

        // --- Initialize Chart.js ---
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('attendanceChart').getContext('2d');

            // Fallback mock data in case Laravel backend isn't sending variables yet
            const labels = {!! isset($chartLabels) ? json_encode($chartLabels) : '["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"]' !!};
            const data = {!! isset($chartData) ? json_encode($chartData) : '[8, 10, 9, 12, 11, 5, 0]' !!};

            // Setup gradient for graph fill
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(10, 58, 130, 0.4)'); // PEL Blue start
            gradient.addColorStop(1, 'rgba(10, 58, 130, 0.0)'); // Transparent end

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Present Interns',
                        data: data,
                        borderColor: '#0A3A82', // PEL Blue Line
                        backgroundColor: gradient,
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0A3A82',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: 0.4 // Smooth curve
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#062352',
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { precision: 0, color: '#8392a5' },
                            grid: { borderDash: [5, 5], color: '#e2e8f0' },
                            border: { display: false }
                        },
                        x: {
                            ticks: { color: '#8392a5' },
                            grid: { display: false },
                            border: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
