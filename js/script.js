document.addEventListener('DOMContentLoaded', () => {
    console.log('script.js loaded');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const dropdownItems = document.querySelectorAll('.dropdown-item[data-type]');
    const dropdownToggle = document.getElementById('universityTypeDropdown');
    const resourceGrid = document.getElementById('resourceGrid');
    let allUnis = [];
    let currentType = 'All';

    // Load JSON data for main page
    Promise.all([
        fetch('./data/public_universities.json').then(res => res.json()),
        fetch('./data/private_universities.json').then(res => res.json())
    ])
    .then(([publicData, privateData]) => {
        const pub = publicData.map(u => ({ 
            name: u.name, 
            website: u.website || '', 
            type: 'Public', 
            icon: 'building' 
        }));
        const priv = privateData.map(u => ({ 
            name: u.name, 
            website: u.website || '', 
            type: 'Private', 
            icon: 'shield' 
        }));
        allUnis = [...pub, ...priv];
        console.log(`Loaded universities: ${allUnis.length}`, allUnis);
        renderGrid(allUnis);
        populateTicker();
    })
    .catch(err => {
        resourceGrid.innerHTML = '<p class="text-danger text-center">Failed to load data.</p>';
        console.error(err);
    });

    function renderGrid(list) {
        const resourceGrid = document.getElementById('resourceGrid');
        resourceGrid.innerHTML = '';
        if (list.length === 0) {
            resourceGrid.innerHTML = '<p class="text-center">No results found.</p>';
            return;
        }
        list.forEach(u => {
            const col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4 mb-4';
    
            const card = document.createElement('div');
            card.className = 'card h-100 shadow-sm';
            card.style.backgroundColor = 'var(--surface-color)';
            card.style.color = 'var(--on-surface-color)';
    
            const cardBody = document.createElement('div');
            cardBody.className = 'card-body text-center';
    
            const icon = document.createElement('i');
            icon.className = `bi bi-${u.icon} fs-1 mb-2`;
            icon.style.color = 'var(--primary-color)';
    
            const title = document.createElement('h5');
            title.className = 'card-title';
            title.style.color = 'var(--secondary-color)';
            title.textContent = u.name;
    
            const details = document.createElement('p');
            details.className = 'card-text';
            details.style.color = 'var(--on-background-color)';
            details.textContent = `${u.website} - ${u.type}`;
    
            const link = document.createElement('a');
            link.href = `university.html?name=${encodeURIComponent(u.name)}`;
            link.className = 'stretched-link';
    
            cardBody.appendChild(icon);
            cardBody.appendChild(title);
            cardBody.appendChild(details);
    
            card.appendChild(cardBody);
            card.appendChild(link);
            col.appendChild(card);
            resourceGrid.appendChild(col);
        });
    }

    function applyFilters() {
        const term = (searchInput?.value || '').trim().toLowerCase();
        console.log('applyFilters:', { type: currentType, term, totalUnis: allUnis.length });
        let filtered = allUnis;
        if (currentType !== 'All') {
            filtered = filtered.filter(u => u.type === currentType);
        }
        if (term) {
            filtered = filtered.filter(u =>
                (u.name || '').toLowerCase().includes(term) ||
                (u.website || '').toLowerCase().includes(term)
            );
        }
        renderGrid(filtered);
    }

    function populateTicker() {
        const ticker = document.querySelector('.ticker');
        if (!ticker) return;
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

    // Back to top button logic
    const backBtn = document.getElementById('backToTopBtn');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 200) backBtn.classList.add('show');
        else backBtn.classList.remove('show');
    });
    backBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});