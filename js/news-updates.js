document.addEventListener('DOMContentLoaded', function() {
    loadNewsAndUpdates();
});

async function loadNewsAndUpdates() {
    try {
        const response = await fetch('api/get-news.php');
        const result = await response.json();

        if (result.success) {
            displayNewsAndUpdates(result.data);
        } else {
            throw new Error(result.message || 'Failed to load news and updates');
        }
    } catch (error) {
        console.error('Error:', error);
        showError('Failed to load news and updates. Please try again later.');
    }
}

function displayNewsAndUpdates(news) {
    const newsContainer = document.getElementById('newsContainer');
    if (!newsContainer) return;

    newsContainer.innerHTML = news.map(item => createNewsCard(item)).join('');
}

function createNewsCard(item) {
    const publishDate = new Date(item.publish_date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    const categoryClass = item.category.toLowerCase().replace(' ', '-');
    
    return `
        <div class="news-card">
            <div class="card-body">
                <span class="category-badge ${categoryClass}">${item.category}</span>
                <h3>${item.title}</h3>
                <p>${item.content}</p>
                ${item.university_name ? `<div class="university-name">${item.university_name}</div>` : ''}
                <div class="publish-date">Published on ${publishDate}</div>
                <a href="#" class="read-more" onclick="showFullNews(${item.id})">Read More</a>
            </div>
        </div>
    `;
}

function showFullNews(newsId) {
    // TODO: Implement full news view functionality
    console.log('Show full news for ID:', newsId);
}

function showError(message) {
    const newsContainer = document.getElementById('newsContainer');
    if (newsContainer) {
        newsContainer.innerHTML = `
            <div class="alert alert-danger" role="alert">
                ${message}
            </div>
        `;
    }
} 