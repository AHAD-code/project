<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Attendance | IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fe; }
        .sidebar { width: 260px; height: 100vh; position: fixed; background: #111c43; color: #a3aed1; }
        .sidebar .nav-link { color: #a3aed1; padding: 12px 20px; margin: 4px 15px; border-radius: 8px; }
        .sidebar .nav-link.active { background: rgba(255, 255, 255, 0.1); color: #ffffff; }
        .main-content { margin-left: 260px; padding: 24px; }
    </style>
</head>
<body>

    <!-- Sidebar (Same as your other pages) -->
    <div class="sidebar">
        <div class="d-flex align-items-center p-4"><h4 class="text-white fw-bold">IMS Panel</h4></div>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ route('supervisor.dashboard') }}" class="nav-link"><i class="fas fa-home"></i> My Dashboard</a></li>
            <li class="nav-item"><a href="{{ route('supervisor.attendance') }}" class="nav-link active"><i class="fas fa-chart-line"></i> Attendance Reports</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Add Attendance Record</h4>
            <a href="{{ route('supervisor.attendance') }}" class="btn btn-light border rounded-pill px-4">Back to List</a>
        </div>

        <div class="card border-0 rounded-4 shadow-sm p-4" style="max-width: 600px;">
            <form action="{{ route('supervisor.attendance.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Select Intern</label>
                    <select name="intern_id" class="form-select form-select-lg" required>
                        <option value="">-- Choose an Intern --</option>
                        @foreach($interns as $intern)
                            <option value="{{ $intern->id }}">{{ $intern->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Date</label>
                    <input type="date" name="date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select form-select-lg" required>
                        <option value="Present">Present</option>
                        <option value="Absent">Absent</option>
                        <option value="Leave">Leave</option>
                    </select>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 w-100 fw-bold shadow">
                        Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
