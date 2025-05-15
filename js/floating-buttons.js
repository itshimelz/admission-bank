document.addEventListener('DOMContentLoaded', () => {
    const newsBtn = document.querySelector('.floating-news-btn');
    const backToTopBtn = document.querySelector('.back-to-top');

    // Function to scroll to news section
    function scrollToNewsSection() {
        const newsSection = document.querySelector('.news-updates-section');
        if (newsSection) {
            newsSection.scrollIntoView({ behavior: 'smooth' });
        }
    }

    // Function to scroll to top
    function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    // Add click event listeners
    if (newsBtn) {
        newsBtn.addEventListener('click', scrollToNewsSection);
    }
    if (backToTopBtn) {
        backToTopBtn.addEventListener('click', scrollToTop);
    }

    // Handle button visibility based on scroll position
    function updateButtonVisibility() {
        const scrollPosition = window.scrollY;
        const documentHeight = document.documentElement.scrollHeight;
        const windowHeight = window.innerHeight;
        const bottomThreshold = documentHeight - windowHeight - 100; // 100px threshold from bottom

        if (scrollPosition > bottomThreshold) {
            // Near bottom - hide news button, show back to top
            newsBtn?.classList.add('hide');
            backToTopBtn?.classList.add('show');
        } else if (scrollPosition > 200) {
            // Scrolled down but not at bottom - show both buttons
            newsBtn?.classList.remove('hide');
            backToTopBtn?.classList.add('show');
        } else {
            // At top - show only news button
            newsBtn?.classList.remove('hide');
            backToTopBtn?.classList.remove('show');
        }
    }

    // Add scroll event listener
    window.addEventListener('scroll', updateButtonVisibility);
    
    // Initial state
    updateButtonVisibility();
}); 