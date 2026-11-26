<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../services/ticket_repo.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/tickets.php');
    exit;
}

$action = $_POST['action'] ?? '';
if ($action === 'create') {
    createTicket(
        $pdo,
        (int) $_POST['resource_id'],
        (int) $_SESSION['user']['ID'],
        trim($_POST['type'] ?? 'nie_wiem'),
        trim($_POST['description'] ?? '')
    );
} elseif ($action === 'close' && isAdmin()) {
    closeTicket($pdo, (int) $_POST['ticket_id']);
}

header('Location: ../pages/tickets.php');
exit;
