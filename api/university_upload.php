<?php
require_once 'check-auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload University Details - Admission Bank</title>
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
        .timeline-event {
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 5px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .remove-event {
            color: #dc3545;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .remove-event:hover {
            color: #bb2d3b;
        }
        .form-section {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            border: 1px solid #dee2e6;
        }
        .form-section h3 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e9ecef;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
        .btn-primary {
            background-color: #2c3e50;
            border-color: #2c3e50;
        }
        .btn-primary:hover {
            background-color: #1a252f;
            border-color: #1a252f;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .form-control:focus, .form-select:focus {
            border-color: #2c3e50;
            box-shadow: 0 0 0 0.25rem rgba(44, 62, 80, 0.25);
        }
        .alert {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- University Header -->
    <div class="university-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="mb-3 text-white">Upload University Details</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="index.html" class="text-white">Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Upload University Details</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4 text-end">
                    <a href="/admission-bank/index.php" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="text-muted">
                        <i class="bi bi-info-circle"></i> Fields marked with * are required
                    </div>
                </div>

                <div class="alert alert-success" role="alert" id="successAlert">
                    University details uploaded successfully!
                </div>

                <div class="alert alert-danger" role="alert" id="errorAlert">
                    Error uploading university details. Please try again.
                </div>
                
                <form id="universityForm" class="needs-validation" novalidate>
                    <!-- Basic Information -->
                    <div class="form-section">
                        <h3><i class="bi bi-info-circle me-2"></i>Basic Information</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label required-field">University Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">Please enter the university name.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="type" class="form-label required-field">University Type</label>
                                <select class="form-select" id="type" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="Public">Public</option>
                                    <option value="Private">Private</option>
                                    <option value="National">National</option>
                                </select>
                                <div class="invalid-feedback">Please select the university type.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="website" class="form-label required-field">Website</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-globe"></i></span>
                                    <input type="url" class="form-control" id="website" name="website" required>
                                </div>
                                <div class="invalid-feedback">Please enter a valid website URL.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="established_year" class="form-label required-field">Established Year</label>
                                <input type="number" class="form-control" id="established_year" name="established_year" min="1800" max="2024" required>
                                <div class="invalid-feedback">Please enter a valid year between 1800 and 2024.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="location" class="form-label required-field">Location</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input type="text" class="form-control" id="location" name="location" required>
                                </div>
                                <div class="invalid-feedback">Please enter the university location.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="ranking" class="form-label">Ranking</label>
                                <input type="number" class="form-control" id="ranking" name="ranking" min="1">
                                <div class="invalid-feedback">Please enter a valid ranking number.</div>
                            </div>
                            <div class="col-12">
                                <label for="description" class="form-label required-field">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                <div class="invalid-feedback">Please enter a description of the university.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    <div class="form-section">
                        <h3><i class="bi bi-card-list me-2"></i>Additional Information</h3>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="application_deadline" class="form-label">Application Deadline</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                                    <input type="date" class="form-control" id="application_deadline" name="application_deadline">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="tuition_fee" class="form-label">Tuition Fee (BDT)</label>
                                <div class="input-group">
                                    <span class="input-group-text">৳</span>
                                    <input type="number" class="form-control" id="tuition_fee" name="tuition_fee" min="0">
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="admission_requirements" class="form-label">Admission Requirements</label>
                                <textarea class="form-control" id="admission_requirements" name="admission_requirements" rows="3"></textarea>
                            </div>
                            <div class="col-12">
                                <label for="contact_info" class="form-label">Contact Information</label>
                                <textarea class="form-control" id="contact_info" name="contact_info" rows="3" placeholder="Phone: +880-XXX-XXXXXXX&#10;Email: example@university.edu&#10;Address: University Address"></textarea>
                            </div>
                            <div class="col-12">
                                <label for="programs_offered" class="form-label">Programs Offered</label>
                                <textarea class="form-control" id="programs_offered" name="programs_offered" rows="3" placeholder="Enter programs separated by commas"></textarea>
                            </div>
                            <div class="col-12">
                                <label for="campus_facilities" class="form-label">Campus Facilities</label>
                                <textarea class="form-control" id="campus_facilities" name="campus_facilities" rows="3" placeholder="Enter facilities separated by commas"></textarea>
                            </div>
                            <div class="col-12">
                                <label for="image_url" class="form-label">University Logo URL</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-image"></i></span>
                                    <input type="url" class="form-control" id="image_url" name="image_url" placeholder="https://example.com/logo.png">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Events -->
                    <div class="form-section">
                        <h3><i class="bi bi-calendar-event me-2"></i>Application Timeline Events</h3>
                        <div id="timelineEvents">
                            <!-- Timeline events will be added here -->
                        </div>
                        <button type="button" class="btn btn-secondary mt-3" id="addTimelineEvent">
                            <i class="bi bi-plus-circle"></i> Add Timeline Event
                        </button>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-cloud-upload"></i> Upload University Details
                        </button>
                        <button type="reset" class="btn btn-secondary ms-2">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('universityForm');
            const addTimelineEventBtn = document.getElementById('addTimelineEvent');
            const timelineEventsContainer = document.getElementById('timelineEvents');
            const successAlert = document.getElementById('successAlert');
            const errorAlert = document.getElementById('errorAlert');

            // Add timeline event
            addTimelineEventBtn.addEventListener('click', function() {
                const eventDiv = document.createElement('div');
                eventDiv.className = 'timeline-event';
                eventDiv.innerHTML = `
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label required-field">Event Name</label>
                            <input type="text" class="form-control" name="timeline_events[][event_name]" required>
                            <div class="invalid-feedback">Please enter the event name.</div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label required-field">Event Date</label>
                            <input type="date" class="form-control" name="timeline_events[][event_date]" required>
                            <div class="invalid-feedback">Please select the event date.</div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label required-field">Event Type</label>
                            <select class="form-select" name="timeline_events[][event_type]" required>
                                <option value="">Select Type</option>
                                <option value="Application">Application</option>
                                <option value="Document">Document</option>
                                <option value="Test">Test</option>
                                <option value="Interview">Interview</option>
                                <option value="Result">Result</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="invalid-feedback">Please select the event type.</div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger w-100 remove-event text-white">
                                <i class="bi bi-trash"></i> Remove
                            </button>
                        </div>
                        <div class="col-12">
                            <label class="form-label required-field">Event Description</label>
                            <textarea class="form-control" name="timeline_events[][event_description]" rows="2" required></textarea>
                            <div class="invalid-feedback">Please enter the event description.</div>
                        </div>
                    </div>
                `;

                timelineEventsContainer.appendChild(eventDiv);

                // Add remove event listener
                eventDiv.querySelector('.remove-event').addEventListener('click', function() {
                    eventDiv.remove();
                });
            });

            // Form submission
            form.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!form.checkValidity()) {
                    e.stopPropagation();
                    form.classList.add('was-validated');
                    return;
                }

                const formData = new FormData(form);
                const data = {};

                // Convert FormData to JSON object
                for (let [key, value] of formData.entries()) {
                    if (key.includes('timeline_events')) {
                        if (!data.timeline_events) {
                            data.timeline_events = [];
                        }
                        const index = parseInt(key.match(/\[(\d+)\]/)[1]);
                        const field = key.match(/\[([^\]]+)\]$/)[1];
                        if (!data.timeline_events[index]) {
                            data.timeline_events[index] = {};
                        }
                        data.timeline_events[index][field] = value;
                    } else {
                        data[key] = value;
                    }
                }

                try {
                    const response = await fetch('api/upload.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    });

                    const result = await response.json();

                    if (result.success) {
                        successAlert.style.display = 'block';
                        errorAlert.style.display = 'none';
                        form.reset();
                        form.classList.remove('was-validated');
                        timelineEventsContainer.innerHTML = '';
                        
                        // Hide success message after 5 seconds
                        setTimeout(() => {
                            successAlert.style.display = 'none';
                        }, 5000);
                    } else {
                        throw new Error(result.error || 'Failed to upload university details');
                    }
                } catch (error) {
                    errorAlert.textContent = 'Error: ' + error.message;
                    errorAlert.style.display = 'block';
                    successAlert.style.display = 'none';
                    console.error(error);
                }
            });
        });
    </script>
</body>
</html> 