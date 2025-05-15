// Sample data structure - In a real application, this would come from an API
const statisticsData = {
    admissionRates: {
        labels: ['2020', '2021', '2022', '2023'],
        datasets: [{
            label: 'Public Universities',
            data: [15, 18, 20, 22],
            borderColor: '#007bff',
            tension: 0.1
        }, {
            label: 'Private Universities',
            data: [25, 28, 30, 32],
            borderColor: '#28a745',
            tension: 0.1
        }]
    },
    seatDistribution: {
        labels: ['Engineering', 'Business', 'Medical', 'Arts', 'Science'],
        datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: [
                '#007bff',
                '#28a745',
                '#dc3545',
                '#ffc107',
                '#17a2b8'
            ]
        }]
    },
    cutoffMarks: {
        labels: ['Engineering', 'Business', 'Medical', 'Arts', 'Science'],
        datasets: [{
            label: '2023 Cutoff',
            data: [85, 80, 90, 75, 78],
            backgroundColor: 'rgba(0, 123, 255, 0.5)'
        }, {
            label: '2022 Cutoff',
            data: [83, 78, 88, 73, 76],
            backgroundColor: 'rgba(40, 167, 69, 0.5)'
        }]
    },
    testStats: {
        labels: ['Applied', 'Appeared', 'Passed', 'Selected'],
        datasets: [{
            label: '2023 Statistics',
            data: [1000, 800, 400, 200],
            backgroundColor: 'rgba(0, 123, 255, 0.5)'
        }]
    }
};

// Chart configurations
const chartConfigs = {
    admissionRateChart: {
        type: 'line',
        data: statisticsData.admissionRates,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Admission Rate Trends (%)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    },
    seatDistributionChart: {
        type: 'pie',
        data: statisticsData.seatDistribution,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Program-wise Seat Distribution (%)'
                }
            }
        }
    },
    cutoffMarksChart: {
        type: 'bar',
        data: statisticsData.cutoffMarks,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Previous Year Cutoff Marks (%)'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    },
    testStatsChart: {
        type: 'bar',
        data: statisticsData.testStats,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Admission Test Statistics'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    }
};

// Initialize charts when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Create all charts
    Object.entries(chartConfigs).forEach(([chartId, config]) => {
        const ctx = document.getElementById(chartId).getContext('2d');
        new Chart(ctx, config);
    });

    // Initialize filters
    initializeFilters();
});

// Filter functionality
function initializeFilters() {
    const universityFilter = document.getElementById('universityFilter');
    const yearFilter = document.getElementById('yearFilter');
    const programFilter = document.getElementById('programFilter');

    // Add event listeners for filters
    [universityFilter, yearFilter, programFilter].forEach(filter => {
        filter.addEventListener('change', updateCharts);
    });
}

function updateCharts() {
    // In a real application, this would fetch new data based on filter values
    // and update the charts accordingly
    console.log('Filters changed, updating charts...');
    // Add your API call here to fetch filtered data
}

// Add this to your existing navigation
document.querySelectorAll('.nav-links a').forEach(link => {
    if (link.getAttribute('href') === 'statistics.html') {
        link.classList.add('active');
    }
}); 