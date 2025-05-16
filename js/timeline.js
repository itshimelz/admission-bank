document.addEventListener('DOMContentLoaded', function() {
    loadTimelineEvents();
});

async function loadTimelineEvents() {
    try {
        const response = await fetch('api/timeline_events.php');
        const result = await response.json();

        if (result.success) {
            displayTimelineEvents(result.data);
        } else {
            throw new Error(result.message || 'Failed to load timeline events');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('Failed to load timeline events. Please try again later.');
    }
}

// ... rest of the existing code ... 