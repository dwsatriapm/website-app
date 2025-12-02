<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_role']);
}

function hasRole($role) {
    if (!isLoggedIn()) return false;
    
    if (is_array($role)) {
        return in_array($_SESSION['user_role'], $role);
    }
    
    return $_SESSION['user_role'] === $role;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: ' . url('login.php'));
        exit;
    }
}

function requireRole($role) {
    requireLogin();
    
    if (!hasRole($role)) {
        header('Location: ' . url('403.php')); 
        exit;
    }
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: ' . url('login.php'));
    exit;
}

function getCurrentUser() {
    if (!isLoggedIn()) return null;
    
    return [
        'id' => $_SESSION['user_id'],
        'nama' => $_SESSION['user_nama'],
        'username' => $_SESSION['user_username'],
        'email' => $_SESSION['user_email'] ?? null,
        'role' => $_SESSION['user_role']
    ];
}
?>