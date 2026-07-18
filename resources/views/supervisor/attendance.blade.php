<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Reports | IMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7fe; }
        .sidebar { width: 260px; height: 100vh; position: fixed; background: #111c43; color: #a3aed1; z-index: 1000; }
        .sidebar .nav-link { color: #a3aed1; padding: 12px 20px; margin: 4px 15px; border-radius: 8px; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { background: rgba(255, 255, 255, 0.1); color: #ffffff; }
        .main-content { margin-left: 260px; padding: 24px; }
        .top-navbar { background: white; border-radius: 16px; padding: 15px 24px; box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.02); margin-bottom: 24px; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="d-flex align-items-center p-4 mb-3">
            <div class="bg-primary text-white rounded p-2 me-2"><i class="fas fa-layer-group"></i></div>
            <h4 class="text-white mb-0 fw-bold">IMS Panel</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item"><a href="{{ route('supervisor.dashboard') }}" class="nav-link"><i class="fas fa-home"></i> My Dashboard</a></li>
            <li class="nav-item"><a href="{{ route('supervisor.dashboard') }}" class="nav-link"><i class="fas fa-users"></i> Assigned Interns</a></li>
            <li class="nav-item"><a href="{{ route('supervisor.tasks') }}" class="nav-link"><i class="fas fa-tasks"></i> Task Board</a></li>
            <li class="nav-item"><a href="{{ route('supervisor.attendance') }}" class="nav-link active"><i class="fas fa-chart-line"></i> Attendance Reports</a></li>
        </ul>
    </div>

    <!-- MAIN CONTENT -->

    <div class="main-content">
        <div class="top-navbar d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0 fw-bold text-dark">Attendance Management</h5>
            </div>

        </div>
        <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark mb-0">Daily Logs</h4>
    <div>
        <a href="{{ route('supervisor.attendance.create') }}" class="btn btn-success rounded-pill px-4 me-2">
            <i class="fas fa-plus me-2"></i> Add Attendance
        </a>
        <button class="btn btn-primary rounded-pill px-4"><i class="fas fa-download me-2"></i> Export Report</button>
    </div>
</div>

        <div class="card border-0 rounded-4 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Date</th>
                            <th>Intern Name</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $record)
                        <tr>
                            <td class="ps-4">{{ \Carbon\Carbon::parse($record->date)->format('D, M d, Y') }}</td>
                            <td>{{ $record->intern->name ?? 'N/A' }}</td>
                            <td><span class="badge bg-{{ $record->status == 'Present' ? 'success' : 'danger' }}">{{ $record->status }}</span></td>
                            <td class="text-end pe-4">
                                <!-- Trigger Button -->
                                <button type="button"
                                        class="btn btn-sm btn-light border text-primary rounded-pill px-3"
                                        onclick="openModal('{{ $record->id }}', '{{ $record->intern->name }}', '{{ $record->date }}', '{{ $record->status }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- BOOTSTRAP MODAL -->
    <div class="modal fade" id="editModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="fw-bold">Edit Attendance Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editForm" method="POST" action="">
                    @csrf @method('PUT')
                    <div class="modal-body px-4">
                        <p>Intern: <span id="modalIntern" class="fw-bold"></span></p>
                        <p>Date: <span id="modalDate" class="fw-bold"></span></p>
                        <label class="form-label">Update Status</label>
                        <select name="status" id="modalStatus" class="form-select">
                            <option value="Present">Present</option>
                            <option value="Absent">Absent</option>
                            <option value="Leave">Leave</option>
                        </select>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openModal(id, name, date, status) {
            document.getElementById('editForm').action = '/supervisor/attendance/' + id;
            document.getElementById('modalIntern').innerText = name;
            document.getElementById('modalDate').innerText = date;
            document.getElementById('modalStatus').value = status;
            var myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        }
    </script>
</body>
</html>
