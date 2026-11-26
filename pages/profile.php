<?php
require_once __DIR__ . '/../auth/guard.php';
requireLogin();

$profile = $_SESSION['user'];
function escProfile($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <title>Profil</title>
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
   <h1>Profil uzytkownika</h1>
   <p>Imie i nazwisko: <?php echo escProfile($profile['Imie'] . ' ' . $profile['Nazwisko']); ?></p>
   <p>Stanowisko: <?php echo escProfile($profile['Stanowisko']); ?></p>
   <p>Login: <?php echo escProfile($profile['Login']); ?></p>
   <p>Email: <?php echo escProfile($profile['Email']); ?></p>
   <p>Rola: <?php echo isAdmin() ? 'administrator' : 'uzytkownik'; ?></p>
</main>
</body>
</html>
