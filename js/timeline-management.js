document.addEventListener('DOMContentLoaded', function() {
    const universityId = document.getElementById('universityId').value;
    const timelineEvents = document.getElementById('timelineEvents');
    const eventForm = document.getElementById('eventForm');
    const saveEventBtn = document.getElementById('saveEvent');
    const modalTitle = document.getElementById('modalTitle');
    const addEventModal = new bootstrap.Modal(document.getElementById('addEventModal'));

    let editingEventId = null;

    // Load timeline events
    async function loadTimelineEvents() {
        try {
            const response = await fetch(`api/timeline_events.php?university_id=${universityId}`);
            const data = await response.json();
            
            if (data.records) {
                timelineEvents.innerHTML = data.records.map(event => `
                    <tr>
                        <td>${event.event_name}</td>
                        <td>
                            <div class="text-truncate" style="max-width: 200px;" data-bs-toggle="tooltip" title="${event.event_description || 'No description'}">
                                ${event.event_description || 'No description'}
                            </div>
                        </td>
                        <td>${new Date(event.event_date).toLocaleDateString()}</td>
                        <td>${event.event_type}</td>
                        <td>
                            <span class="badge bg-${event.status === 'active' ? 'success' : 'secondary'}">
                                ${event.status}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-2" onclick="editEvent(${event.id})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger" onclick="deleteEvent(${event.id})">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
            } else {
                timelineEvents.innerHTML = '<tr><td colspan="6" class="text-center">No events found</td></tr>';
            }
        } catch (error) {
            console.error('Error loading timeline events:', error);
            timelineEvents.innerHTML = '<tr><td colspan="6" class="text-center text-danger">Error loading events</td></tr>';
        }
    }

    // Save event
    async function saveEvent(eventData) {
        try {
            const method = editingEventId ? 'PUT' : 'POST';
            const response = await fetch('api/timeline_events.php', {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    ...eventData,
                    university_id: universityId
                })
            });

            const data = await response.json();
            
            if (response.ok) {
                addEventModal.hide();
                loadTimelineEvents();
                resetForm();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error saving event:', error);
            alert(error.message);
        }
    }

    // Delete event
    async function deleteEvent(eventId) {
        if (!confirm('Are you sure you want to delete this event?')) return;

        try {
            const response = await fetch('api/timeline_events.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: eventId })
            });

            const data = await response.json();
            
            if (response.ok) {
                loadTimelineEvents();
            } else {
                throw new Error(data.message);
            }
        } catch (error) {
            console.error('Error deleting event:', error);
            alert(error.message);
        }
    }

    // Edit event
    async function editEvent(eventId) {
        try {
            const response = await fetch(`api/timeline_events.php?university_id=${universityId}`);
            const data = await response.json();
            
            if (data.records) {
                const event = data.records.find(e => e.id === eventId);
                if (event) {
                    editingEventId = event.id;
                    document.getElementById('eventId').value = event.id;
                    document.getElementById('eventName').value = event.event_name;
                    document.getElementById('eventDescription').value = event.event_description || '';
                    document.getElementById('eventDate').value = event.event_date;
                    document.getElementById('eventType').value = event.event_type;
                    document.getElementById('eventStatus').value = event.status;
                    
                    modalTitle.textContent = 'Edit Event';
                    addEventModal.show();
                }
            }
        } catch (error) {
            console.error('Error loading event details:', error);
            alert('Error loading event details');
        }
    }

    // Reset form
    function resetForm() {
        editingEventId = null;
        eventForm.reset();
        modalTitle.textContent = 'Add New Event';
    }

    // Event listeners
    saveEventBtn.addEventListener('click', function() {
        const eventData = {
            id: editingEventId,
            event_name: document.getElementById('eventName').value,
            event_description: document.getElementById('eventDescription').value,
            event_date: document.getElementById('eventDate').value,
            event_type: document.getElementById('eventType').value,
            status: document.getElementById('eventStatus').value
        };

        saveEvent(eventData);
    });

    // Load events on page load
    loadTimelineEvents();

    // Make functions available globally
    window.editEvent = editEvent;
    window.deleteEvent = deleteEvent;
}); 