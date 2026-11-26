<?php
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../index.php');
    exit;
}

$login = trim($_POST['emailinput'] ?? '');
$password = $_POST['passwordinput'] ?? '';

if ($login === '' || $password === '') {
    header('Location: ../index.php?error=1');
    exit;
}

$statement = $pdo->prepare(
    'SELECT ID, Imie, Nazwisko, Stanowisko, Dostep, Login, Email, Haslo
     FROM uzytkownicy
     WHERE Login = :login OR Email = :email
     LIMIT 1'
);
$statement->execute(['login' => $login, 'email' => $login]);
$user = $statement->fetch();

if (!$user || !password_verify($password, $user['Haslo'])) {
    header('Location: ../index.php?error=1');
    exit;
}

session_regenerate_id(true);
$_SESSION['user'] = [
    'ID' => (int) $user['ID'],
    'Imie' => $user['Imie'],
    'Nazwisko' => $user['Nazwisko'],
    'Stanowisko' => $user['Stanowisko'],
    'Dostep' => (int) $user['Dostep'],
    'Login' => $user['Login'],
    'Email' => $user['Email'],
];

header('Location: ../pages/dashboard.php');
exit;
