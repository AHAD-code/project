@php
    use App\Models\Task;
    use Illuminate\Http\Request;

    $successMessage = null;

    // 1. HANDLE DATABASE UPDATE (If form is submitted)
    if (request()->isMethod('put') && request()->has('task_id')) {
        $task = Task::find(request()->task_id);
        if ($task) {
            $task->status = request()->status;
            $task->save();
            $successMessage = "Task status updated successfully!";
        }
    }

    // 2. FETCH DATA FOR THE TABLE
    $query = Task::with('intern');
    if (request()->filled('search')) {
        $query->where('title', 'like', '%' . request()->search . '%');
    }
    $tasks = $query->paginate(10);
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management | IMS</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fe;
            overflow-x: hidden;
        }

        /* Override Bootstrap Primary to match your #4318FF theme */
        .btn-primary { background-color: #4318FF; border-color: #4318FF; }
        .btn-primary:hover { background-color: #3311cc; border-color: #3311cc; }
        .text-primary { color: #4318FF !important; }
        .bg-primary { background-color: #4318FF !important; }

        /* Sidebar Menu */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            background: #111c43;
            color: #a3aed1;
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar .nav-link {
            color: #a3aed1;
            padding: 12px 20px;
            margin: 4px 15px;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
        .sidebar .nav-link i { width: 25px; }

        /* Main Content */
        .main-content {
            margin-left: 260px;
            padding: 24px;
        }

        /* Top Navbar */
        .top-navbar {
            background: white;
            border-radius: 16px;
            padding: 15px 24px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.02);
            margin-bottom: 24px;
        }

        /* Cards & Tables */
        .card {
            border-radius: 16px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.02);
            border: none;
        }
        .table th {
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .main-content { margin-left: 0; padding: 15px; }
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="d-flex align-items-center p-4 mb-3">
            <div class="bg-primary text-white rounded p-2 me-2">
                <i class="fas fa-layer-group"></i>
            </div>
            <h4 class="text-white mb-0 fw-bold">IMS Panel</h4>
        </div>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ Route::has('supervisor.dashboard') ? route('supervisor.dashboard') : '#' }}"
                   class="nav-link {{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i> My Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ Route::has('supervisor.interns') ? route('supervisor.interns') : '#' }}"
                   class="nav-link {{ request()->routeIs('supervisor.interns*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Assigned Interns
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ Route::has('supervisor.tasks') ? route('supervisor.tasks') : '#' }}"
                   class="nav-link {{ request()->routeIs('supervisor.tasks*') ? 'active' : '' }}">
                    <i class="fas fa-tasks"></i> Task Board
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ Route::has('supervisor.attendance') ? route('supervisor.attendance') : '#' }}"
                   class="nav-link {{ request()->routeIs('supervisor.attendance*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Attendance Reports
                </a>
            </li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOP NAVBAR -->
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">Intern Task Board</h5>
                <small class="text-muted">Manage and track intern assignments.</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <form action="{{ url()->current() }}" method="GET" class="m-0">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-0" placeholder="Search tasks...">
                    </div>
                </form>
                <div class="dropdown">
                    <a href="#" class="d-block" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Supervisor') }}&background=4318FF&color=fff" class="rounded-circle shadow-sm" width="45">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- ALERTS -->
        @if($successMessage || session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm" role="alert">
                <i class="fas fa-check-circle me-2"></i> {{ $successMessage ?? session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- TASK TABLE CARD -->
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">Title</th>
                            <th class="py-3">Intern</th>
                            <th class="py-3">Priority</th>
                            <th class="py-3">Status</th>
                            <th class="text-end pe-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">{{ $task->title }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($task->intern->name ?? 'N') }}&background=random&color=fff" class="rounded-circle me-2" width="32" height="32">
                                    <span class="fw-medium">{{ $task->intern->name ?? 'Unassigned' }}</span>
                                </div>
                            </td>
                            <td>
                                @php
                                    $badgeColor = match(strtolower($task->priority)) {
                                        'high' => 'danger',
                                        'medium' => 'warning',
                                        default => 'info'
                                    };
                                @endphp
                                <span class="badge bg-{{ $badgeColor }} bg-opacity-10 text-{{ $badgeColor }} border border-{{ $badgeColor }} rounded-pill px-3 py-2">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusColor = match(strtolower($task->status)) {
                                        'completed' => 'success',
                                        'in progress' => 'primary',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusColor }} rounded-pill px-3 py-2">{{ ucfirst($task->status) }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <button type="button" class="btn btn-sm btn-light text-primary fw-semibold rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#taskModal{{ $task->id }}">
                                    <i class="fas fa-edit me-1"></i> Update
                                </button>
                            </td>
                        </tr>

                        <!-- UNIQUE MODAL FOR THIS TASK -->
                        <div class="modal fade" id="taskModal{{ $task->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form method="POST" action="{{ route('supervisor.tasks.update', $task->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <!-- Hidden field to handle the custom `@php` logic at the top of your file -->
                                    <input type="hidden" name="task_id" value="{{ $task->id }}">

                                    <div class="modal-content border-0 shadow-lg rounded-4">
                                        <div class="modal-header border-bottom-0 pt-4 pb-0 px-4">
                                            <h5 class="modal-title fw-bold text-dark">
                                                <div class="icon-box bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center rounded p-2 me-2" style="width: 35px; height: 35px;">
                                                    <i class="fas fa-tasks fs-6"></i>
                                                </div>
                                                Update Task: {{ $task->title }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <label class="form-label fw-semibold text-muted small">CURRENT STATUS</label>
                                            <select name="status" class="form-select form-select-lg rounded-3 shadow-sm border-0 bg-light">
                                                <option value="Pending" {{ strtolower($task->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="In Progress" {{ strtolower($task->status) == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                                <option value="Completed" {{ strtolower($task->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer border-top-0 pb-4 px-4">
                                            <button type="button" class="btn btn-light rounded-pill px-4 fw-medium shadow-sm" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary rounded-pill px-4 fw-medium shadow-sm">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="bg-light rounded-circle d-inline-flex justify-content-center align-items-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="fas fa-clipboard-list fa-2x text-secondary"></i>
                                </div>
                                <h5 class="fw-semibold text-dark">No tasks found</h5>
                                <p class="mb-0">You currently have no tasks matching this criteria.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if(method_exists($tasks, 'links'))
            <div class="mt-4 d-flex justify-content-end">
                {{ $tasks->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
