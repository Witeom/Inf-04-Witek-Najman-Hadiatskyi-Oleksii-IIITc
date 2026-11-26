<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../services/resource_repo.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/catalog.php');
    exit;
}

$action = $_POST['action'] ?? '';
try {
    if ($action === 'create') {
        createResource($pdo, [
            'name' => trim($_POST['name']),
            'number' => trim($_POST['number']),
            'category' => trim($_POST['category']),
            'building' => $_POST['building'],
            'floor' => $_POST['floor'],
            'room' => $_POST['room'],
            'condition' => $_POST['condition'] ?? 'sprawny',
            'status' => $_POST['status'] ?? 'dostepny',
        ]);
    } elseif ($action === 'update') {
        updateResource($pdo, $_POST['id'], [
            'name' => trim($_POST['name']),
            'number' => trim($_POST['number']),
            'category' => trim($_POST['category']),
            'building' => $_POST['building'],
            'floor' => $_POST['floor'],
            'room' => $_POST['room'],
            'condition' => $_POST['condition'] ?? 'sprawny',
            'status' => $_POST['status'] ?? 'dostepny',
        ]);
    } elseif ($action === 'delete') {
        deleteResource($pdo, $_POST['id']);
    }
} catch (PDOException $exception) {
    header('Location: ../pages/catalog.php?error=1');
    exit;
}

header('Location: ../pages/catalog.php');
exit;
