document.addEventListener('DOMContentLoaded', async () => {
  const urlParams = new URLSearchParams(window.location.search);
  const universityName = urlParams.get('name');
  
  if (!universityName) {
    showError('No university specified');
    return;
  }

  try {
    const response = await fetch(`api/read_one.php?name=${encodeURIComponent(universityName)}`);
    const result = await response.json();
    
    if (!response.ok) {
      throw new Error(result.message || 'University not found');
    }

    if (result.success) {
      displayUniversityDetails(result.data);
      
      // Update timeline management button with university ID
      const timelineBtn = document.getElementById('timelineManagementBtn');
      if (timelineBtn) {
        timelineBtn.href = `/admission-bank/timeline-management.php?university_id=${result.data.id}`;
      }
    } else {
      throw new Error(result.message || 'Failed to load university details');
    }
  } catch (error) {
    console.error('Error:', error);
    showError(error.message || 'Failed to load university details');
  }

  // Add smooth scroll to top for the Back to Top button
  const backToTopBtn = document.getElementById('backToTopBtn');
  if (backToTopBtn) {
    backToTopBtn.addEventListener('click', function(e) {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }
});

function displayUniversityDetails(university) {
  document.title = `${university.name} - Admission Bank`;
  document.getElementById('universityName').textContent = university.name;

  const detailsHtml = `
    <!-- Hero Section -->
    <div class="university-hero mb-5">
      <div class="row align-items-center">
        <div class="col-md-3 text-center">
          <img src="${university.image_url || 'https://via.placeholder.com/300x200?text=University'}" 
               class="university-logo mb-3" alt="${university.name}">
        </div>
        <div class="col-md-9">
          <h1 class="display-4 mb-3">${university.name}</h1>
          <div class="d-flex gap-3 mb-3">
            <span class="badge bg-primary">${university.type}</span>
            ${university.ranking ? `<span class="badge bg-secondary">Rank: ${university.ranking}</span>` : ''}
          </div>
          <div class="contact-info d-flex flex-wrap gap-4">
            <div><i class="bi bi-geo-alt"></i> ${university.location || 'Location not specified'}</div>
            <div><i class="bi bi-globe"></i> 
              <a href="${university.website}" target="_blank" class="text-decoration-none">
                ${university.website || 'Website not available'}
              </a>
            </div>
            <div><i class="bi bi-calendar-event"></i> Established: ${university.established_year || 'Not specified'}</div>
            <div><i class="bi bi-cash"></i> Tuition Fee: ${university.tuition_fee ? '৳' + university.tuition_fee : 'Not specified'}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="row g-4">
      <!-- Left Column -->
      <div class="col-lg-4">
        <!-- About Section -->
        <div class="info-card mb-4">
          <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>About</h5>
          </div>
          <div class="card-body">
            <p class="lead">${university.description || 'No description available.'}</p>
          </div>
        </div>

        <!-- Programs Section -->
        <div class="info-card mb-4">
          <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-mortarboard me-2"></i>Programs Offered</h5>
          </div>
          <div class="card-body">
            <div class="program-grid">
              ${(university.programs_offered || 'No programs information available.').split(',').map(program => 
                `<div class="program-item">
                  <i class="bi bi-check2-circle text-success me-2"></i>${program.trim()}
                </div>`
              ).join('')}
            </div>
          </div>
        </div>

        <!-- Facilities Section -->
        <div class="info-card mb-4">
          <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-building me-2"></i>Campus Facilities</h5>
          </div>
          <div class="card-body">
            <div class="facility-grid">
              ${(university.campus_facilities || 'No facilities information available.').split(',').map(facility => 
                `<div class="facility-item">
                  <i class="bi bi-check-circle me-1"></i>${facility.trim()}
                </div>`
              ).join('')}
            </div>
          </div>
        </div>
      </div>

      <!-- Right Column -->
      <div class="col-lg-8">
        <!-- Admission Requirements -->
        <div class="info-card mb-4">
          <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Admission Requirements</h5>
          </div>
          <div class="card-body">
            <div class="requirements-content">
              ${university.admission_requirements || 'No admission requirements specified.'}
            </div>
          </div>
        </div>

        <!-- Application Timeline -->
        ${displayTimelineEvents(university.timeline_events)}

        <!-- Contact Information -->
        <div class="info-card mb-4">
          <div class="card-header">
            <h5 class="mb-0"><i class="bi bi-telephone me-2"></i>Contact Information</h5>
          </div>
          <div class="card-body">
            <div class="contact-details">
              ${university.contact_info ? university.contact_info.split('\n').map(line => {
                if (line.toLowerCase().includes('phone')) {
                  return `<div><i class='bi bi-telephone'></i> ${line.replace('Phone:', '<strong>Phone:</strong>')}</div>`;
                } else if (line.toLowerCase().includes('email')) {
                  return `<div><i class='bi bi-envelope'></i> ${line.replace('Email:', '<strong>Email:</strong>')}</div>`;
                } else if (line.toLowerCase().includes('address')) {
                  return `<div><i class='bi bi-geo-alt'></i> ${line.replace('Address:', '<strong>Address:</strong>')}</div>`;
                } else {
                  return `<div>${line}</div>`;
                }
              }).join('') : 'No contact information available.'}
            </div>
          </div>
        </div>
      </div>
    </div>
  `;

  document.getElementById('university-details').innerHTML = detailsHtml;
}

function displayTimelineEvents(events) {
  if (!events || events.length === 0) {
    return '';
  }

  const getEventIcon = (type) => {
    switch (type) {
      case 'Application': return 'bi-file-earmark-text';
      case 'Document': return 'bi-file-earmark-check';
      case 'Test': return 'bi-pencil-square';
      case 'Interview': return 'bi-person-video3';
      case 'Result': return 'bi-trophy';
      default: return 'bi-calendar-event';
    }
  };

  const getEventColor = (type) => {
    switch (type) {
      case 'Application': return 'primary';
      case 'Document': return 'info';
      case 'Test': return 'warning';
      case 'Interview': return 'success';
      case 'Result': return 'danger';
      default: return 'secondary';
    }
  };

  return `
    <div class="info-card mb-4">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Application Timeline</h5>
        <span class="badge bg-primary">${events.length} Events</span>
      </div>
      <div class="card-body">
        <div class="timeline">
          ${events.map((event, index) => `
            <div class="timeline-item ${index % 2 === 0 ? 'timeline-left' : 'timeline-right'}">
              <div class="timeline-badge bg-${getEventColor(event.event_type)}">
                <i class="bi ${getEventIcon(event.event_type)}"></i>
              </div>
              <div class="timeline-content">
                <div class="timeline-header">
                  <h6 class="mb-1">${event.event_name}</h6>
                  <span class="badge bg-${getEventColor(event.event_type)}">${event.event_type}</span>
                </div>
                <p class="text-muted mb-1">
                  <i class="bi bi-calendar3 me-1"></i>
                  ${new Date(event.event_date).toLocaleDateString('en-US', { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                  })}
                </p>
                ${event.event_description ? `<p class="mb-0 text-muted">${event.event_description}</p>` : ''}
              </div>
            </div>
          `).join('')}
        </div>
      </div>
    </div>
  `;
}

function showError(message) {
  document.getElementById('university-details').innerHTML = `
    <div class="alert alert-danger" role="alert">
      <i class="bi bi-exclamation-triangle me-2"></i>
      ${message}
    </div>
  `;
} 