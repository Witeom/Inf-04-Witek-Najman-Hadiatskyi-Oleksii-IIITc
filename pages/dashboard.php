<?php
require_once __DIR__ . '/../auth/guard.php';
requireLogin();

$total = $pdo->query('SELECT COUNT(*) FROM zasoby_szkolne')->fetchColumn();
$available = $pdo->query("SELECT COUNT(*) FROM zasoby_szkolne WHERE Status = 'dostepny'")->fetchColumn();
$loans = $pdo->query("SELECT COUNT(*) FROM wyporzyczenia WHERE Status_Wypozyczenia = 'aktywne'")->fetchColumn();
$openTickets = $pdo->query("SELECT COUNT(*) FROM tickety WHERE Status_Ticketu = 'otwarty'")->fetchColumn();
$name = htmlspecialchars($_SESSION['user']['Imie'] . ' ' . $_SESSION['user']['Nazwisko'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <title>Panel - EduResource Manager</title>
   <link rel="stylesheet" href="../style.css">
</head>
<body>
<main class="app-page">
   <nav class="app-nav">
      <a href="dashboard.php">Panel</a>
      <a href="catalog.php">Zasoby</a>
      <a href="loan_issue.php">Wypozyczenia</a>
      <a href="tickets.php">Zgloszenia</a>
      <a href="profile.php">Profil</a>
      <form action="../auth/logout.php" method="POST"><button type="submit">Wyloguj</button></form>
   </nav>
   <h1>Witaj, <?php echo $name; ?></h1>
   <p>Wszystkie zasoby: <strong><?php echo (int) $total; ?></strong></p>
   <p>Dostepne zasoby: <strong><?php echo (int) $available; ?></strong></p>
   <p>Aktywne wypozyczenia: <strong><?php echo (int) $loans; ?></strong></p>
   <p>Otwarte zgloszenia: <strong><?php echo (int) $openTickets; ?></strong></p>
</main>
</body>
</html>
