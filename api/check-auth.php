<?php
session_start();

function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];
}

function checkAdminAuth() {
    // Check if admin is logged in
    if (!isAdmin()) {
        header('Location: /admission-bank/admin-login.html');
        exit;
    }

    // Check session timeout (30 minutes)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        session_unset();
        session_destroy();
        header('Location: /admission-bank/admin-login.html');
        exit;
    }

    // Update last activity time
    $_SESSION['last_activity'] = time();
}

// Check authentication
checkAdminAuth(); 