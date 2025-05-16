<?php
require_once 'api/check-auth.php';

// Check if university_id is provided
if (!isset($_GET['university_id'])) {
    header('Location: index.html');
    exit;
}

$university_id = $_GET['university_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeline Management - Admission Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/media.css">

    <style>
        .university-header {
            background: linear-gradient(rgba(33, 100, 135, 0.9), rgba(33, 100, 135, 0.9)), url('https://images.unsplash.com/photo-1541339907198-e08756dedf3f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');
            background-size: cover;
            background-position: center;
            color: var(--on-primary-color);
            padding: 4rem 0;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="university-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-3 text-white">Timeline Management</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.html" class="text-white">Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Timeline Management</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4 text-end">
                    <a href="javascript:history.back()" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Timeline Events</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal">
                            <i class="bi bi-plus-circle"></i> Add New Event
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Event Name</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="timelineEvents">
                                    <tr>
                                        <td colspan="6" class="text-center">Loading events...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Add/Edit Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <input type="hidden" id="eventId">
                        <input type="hidden" id="universityId" value="<?php echo htmlspecialchars($university_id); ?>">
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="eventName" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="eventDescription" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Event Date</label>
                            <input type="date" class="form-control" id="eventDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventType" class="form-label">Event Type</label>
                            <select class="form-select" id="eventType" required>
                                <option value="">Select Type</option>
                                <option value="Application">Application</option>
                                <option value="Document">Document</option>
                                <option value="Test">Test</option>
                                <option value="Interview">Interview</option>
                                <option value="Result">Result</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="eventStatus" class="form-label">Status</label>
                            <select class="form-select" id="eventStatus" required>
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEvent">Save Event</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/timeline-management.js"></script>
</body>
</html> 