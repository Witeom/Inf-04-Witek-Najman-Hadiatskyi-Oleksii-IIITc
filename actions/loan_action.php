<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../services/loan_repo.php';
requireLogin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/loan_issue.php');
    exit;
}

$action = $_POST['action'] ?? '';
if ($action === 'issue' && isAdmin()) {
    $resourceId = (int) $_POST['resource_id'];
    $userId = (int) $_POST['user_id'];
    $dueDate = $_POST['due_date'] ?? '';

    if ($resourceId && $userId && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dueDate)) {
        issueResource($pdo, $resourceId, $userId, $dueDate);
    }
} elseif ($action === 'return' && isAdmin()) {
    returnResource($pdo, (int) $_POST['loan_id']);
}

header('Location: ../pages/loan_issue.php');
exit;
