<?php
require_once __DIR__ . '/../config/db.php';

function requireLogin()
{
    if (!isset($_SESSION['user'])) {
        header('Location: /index.php');
        exit;
    }
}

function requireAdmin()
{
    requireLogin();
    if (!isset($_SESSION['user']['Dostep']) || (int) $_SESSION['user']['Dostep'] < 9) {
        http_response_code(403);
        exit('Brak uprawnien.');
    }
}

function isAdmin()
{
    return isset($_SESSION['user']['Dostep']) && (int) $_SESSION['user']['Dostep'] >= 9;
}
