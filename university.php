<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Details - Admission Bank</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="icon" type="image/png" href="./assets/logo.png">
  <link rel="stylesheet" href="./css/media.css">
  <link rel="stylesheet" href="./css/university.css">
</head>

<body>
  <div class="university-header">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php" class="text-white">Home</a></li>
          <li class="breadcrumb-item active text-white" aria-current="page" id="universityName">University Details</li>
        </ol>
      </nav>
      <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
        <div class="text-end mt-2">
          <a href="#" class="btn btn-outline-light" id="timelineManagementBtn">
            <i class="bi bi-calendar-event me-2"></i>Manage Timeline Events
          </a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <main class="container py-5">
    <div id="university-details">
      <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
    </div>
  </main>

  <a href="#top" class="back-button" id="backToTopBtn" title="Back to Top">
    <i class="bi bi-arrow-up"></i>
    <span class="visually-hidden">Back to Top</span>
  </a>

  <script src="./js/university.js"></script>
</body>

</html>