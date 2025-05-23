<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/media.css" />
    <link rel="stylesheet" href="./css/news-updates.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" type="image/png" href="./assets/logo.png">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/floating-buttons.css">
    <title>Admission Bank</title>
</head>

<body>
    <main class="bg-light">
        <!-- Redesigned Header Section -->
        <div class="header-section text-center">
            <!-- Logo and Title -->
            <div class="logo-container p-5">
                <img src="./assets/logo.png"
                    alt="MyWiki Logo" class="logo mb-2">
                <h1 class="display-4 fw-bold ">Admission Bank</h1>
                <p class="lead text-muted">Your guide to university admissions in Bangladesh</p>
                
                <!-- Admin Navigation -->
                <?php if(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                <div class="admin-nav mt-3">
                    <div class="btn-group">
                        <a href="/admission-bank/api/university_upload.php" class="btn btn-primary">
                            <i class="bi bi-cloud-upload me-2"></i>Upload University
                        </a>  
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- University Type Selection Banner -->
        <div class="university-type-banner bg-dark text-white p-4 text-center">
            <div class="d-flex justify-content-center align-items-center gap-3">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="universityTypeDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Select University Category
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="universityTypeDropdown">
                        <li><a class="dropdown-item" href="#" data-type="All">All Universities</a></li>
                        <li><a class="dropdown-item" href="#" data-type="Public"><i class="bi bi-building me-2"></i>Public Universities</a></li>
                        <li><a class="dropdown-item" href="#" data-type="Private"><i class="bi bi-shield me-2"></i>Private Universities</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-lightbulb me-2"></i>National Universities</a></li>
                    </ul>
                </div>
                <a href="statistics.html" class="btn btn-outline-light">
                    <i class="bi bi-graph-up me-2"></i>View Statistics
                </a>
            </div>
        </div>

        <!-- Upcoming Exams Section -->
        <section class="exam-row mt-4">
            <h3 class="text-center mb-3">Upcoming admissions <span id="admission-count" class="badge bg-secondary ms-2">0</span></h3>
            <div class="ticker"></div>
        </section>

        <!-- Resources Section with Search Bar -->
        <div class="resources-section container ">
            <!-- Redesigned Search Bar -->
            <div class="search-bar p-4 d-flex justify-content-center">
                <div
                    class="search-container d-flex align-items-center bg-white rounded-pill shadow-sm overflow-hidden w-100 w-md-75 w-lg-50">
                    <div class="input-group">
                        <span class="input-group-text border-0 bg-transparent pe-0">
                            <i class="bi bi-search text-muted ps-2"></i>
                        </span>
                        <input id="searchInput" type="text" placeholder="Search for University Information"
                            class="form-control border-0 shadow-none py-3"
                            aria-label="Search for University Information">
                        <button id="searchBtn" class="btn btn-primary rounded-pill px-4 py-2 m-2" type="button">
                            Search
                        </button>
                    </div>
                </div>
            </div>

            <!-- Resource Grid -->
            <div class="row justify-content-center">
                <div id="resourceGrid" class="row justify-content-center container"></div>
                <div id="showMoreContainer" class="text-center mt-4"></div>
            </div>
        </div>

        <!-- News and Updates Section -->
        <section class="news-updates-section">
            <div class="container">
                <div class="news-updates-header">
                    <h2>News & Updates</h2>
                    <p>Stay informed about the latest admission notices, policy changes, and announcements</p>
                </div>
                <div id="newsContainer" class="row">
                    <!-- News cards will be dynamically loaded here -->
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-light py-3 mt-5">
        <div class="container text-center">
            <p>&copy; 2025 Admission Bank - All rights reserved.</p>
        </div>
    </footer>

    <!-- Floating News Button -->
    <button class="floating-news-btn">
        <i class="bi bi-newspaper"></i> Latest News
    </button>

    <!-- Back to Top Button -->
    <button class="back-to-top">
        <i class="bi bi-arrow-up"></i> Back to Top
    </button>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.min.js"></script>
    <script src="./js/news-updates.js"></script>
    <script src="./js/script.js"></script>
    <script src="./js/floating-buttons.js"></script>
</body>

</html>