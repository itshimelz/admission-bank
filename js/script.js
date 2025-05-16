document.addEventListener('DOMContentLoaded', () => {
    console.log('script.js loaded');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const dropdownItems = document.querySelectorAll('.dropdown-item[data-type]');
    const dropdownToggle = document.getElementById('universityTypeDropdown');
    const resourceGrid = document.getElementById('resourceGrid');
    
    console.log('Resource Grid:', resourceGrid);
    
    let allUnis = [];
    let filteredUnis = [];
    let currentType = 'All';
    let currentPage = 1;
    const universitiesPerPage = 12;

    // Load data from API
    console.log('Starting to load data from API...');
    fetch('api/read.php')
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                console.log('API data loaded successfully');
                allUnis = result.data.map(u => ({ 
                    name: u.name, 
                    website: u.website || '', 
                    type: u.type, 
                    icon: u.type === 'Public' ? 'building' : 'shield' 
                }));
                filteredUnis = [...allUnis];
                console.log(`Loaded universities: ${allUnis.length}`, allUnis);
                
                // Initial render
                renderPage();
                // Initialize other features
                populateTicker();
            } else {
                throw new Error(result.message || 'Failed to load data');
            }
        })
        .catch(err => {
            console.error('Error loading data:', err);
            resourceGrid.innerHTML = '<p class="text-danger text-center">Failed to load data.</p>';
        });

    function renderPage() {
        console.log('Rendering page...');
        if (!resourceGrid) {
            console.error('Resource grid not found!');
            return;
        }

        // Get current universities to display from filtered list
        const startIndex = 0;
        const endIndex = currentPage * universitiesPerPage;
        const currentUnis = filteredUnis.slice(startIndex, endIndex);
        
        console.log(`Showing ${currentUnis.length} universities`);
        
        // Create HTML for universities
        const universitiesHTML = currentUnis.map(u => `
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm" style="background-color: var(--surface-color); color: var(--on-surface-color);">
                    <div class="card-body text-center">
                        <i class="bi bi-${u.icon} fs-1 mb-2" style="color: var(--primary-color);"></i>
                        <h5 class="card-title" style="color: var(--secondary-color);">${u.name}</h5>
                        <p class="card-text" style="color: var(--on-background-color);">${u.website} - ${u.type}</p>
                        <a href="university.php?name=${encodeURIComponent(u.name)}" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        `).join('');

        // Create HTML for show more button if needed
        const remainingCount = filteredUnis.length - endIndex;
        console.log(`Remaining universities: ${remainingCount}`);
        
        const showMoreHTML = remainingCount > 0 ? `
            <div class="col-12 text-center mt-4">
                <button class="btn btn-primary" onclick="window.showMore()">
                    Show More (${remainingCount} remaining)
                </button>
            </div>
        ` : '';

        // Update the grid
        resourceGrid.innerHTML = universitiesHTML + showMoreHTML;
        console.log('Page rendered successfully');
    }

    // Make showMore function available globally
    window.showMore = function() {
        console.log('Show more clicked');
        currentPage++;
        renderPage();
    };

    function applyFilters() {
        const term = (searchInput?.value || '').trim().toLowerCase();
        console.log('Applying filters:', { type: currentType, term, totalUnis: allUnis.length });
        
        // Reset to first page when filtering
        currentPage = 1;
        
        // Apply filters
        filteredUnis = allUnis.filter(u => {
            const matchesType = currentType === 'All' || u.type === currentType;
            const matchesSearch = !term || 
                u.name.toLowerCase().includes(term) || 
                u.website.toLowerCase().includes(term);
            return matchesType && matchesSearch;
        });
        
        console.log(`Filtered universities: ${filteredUnis.length}`);
        renderPage();
    }

    function populateTicker() {
        console.log('Populating ticker...');
        const ticker = document.querySelector('.ticker');
        if (!ticker) {
            console.log('Ticker element not found');
            return;
        }
        ticker.innerHTML = '';
        const inner = document.createElement('div');
        inner.className = 'ticker-inner';
        allUnis.slice(0, 10).forEach(u => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'language-btn ticker-item m-2';
            btn.textContent = u.name;
            inner.appendChild(btn);
        });
        ticker.appendChild(inner);
        const countEl = document.getElementById('admission-count');
        if (countEl) countEl.textContent = inner.children.length;
        console.log('Ticker populated successfully');
    }

    dropdownToggle.textContent = 'All Universities';

    dropdownItems.forEach(item => {
        item.addEventListener('click', e => {
            e.preventDefault();
            currentType = item.getAttribute('data-type');
            dropdownItems.forEach(i => i.classList.remove('active'));
            item.classList.add('active');
            dropdownToggle.textContent = currentType === 'All' ? 'All Universities' : `${currentType} Universities`;
            applyFilters();
        });
    });

    searchBtn.addEventListener('click', applyFilters);
    searchInput.addEventListener('keyup', e => {
        if (e.key === 'Enter') applyFilters();
    });

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

    // Show/hide back to top button based on scroll position
    window.addEventListener('scroll', () => {
        const backToTopBtn = document.querySelector('.back-to-top');
        if (window.scrollY > 200) {
            backToTopBtn.classList.add('show');
        } else {
            backToTopBtn.classList.remove('show');
        }
    });
});