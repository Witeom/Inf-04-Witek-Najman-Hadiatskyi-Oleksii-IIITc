<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../services/resource_repo.php';
requireLogin();

$search = trim($_GET['search'] ?? '');
$category = trim($_GET['category'] ?? '');
$resources = getResources($pdo, $search, $category);

function esc($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <title>Katalog zasobow</title>
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
   <h1>Katalog zasobow</h1>
   <form class="app-form" method="GET">
      <input type="text" name="search" value="<?php echo esc($search); ?>" placeholder="Nazwa lub numer">
      <input type="text" name="category" value="<?php echo esc($category); ?>" placeholder="Kategoria">
      <button type="submit">Szukaj</button>
   </form>

   <?php if (isAdmin()) : ?>
   <h2>Dodaj zasob</h2>
   <form class="app-form" action="../actions/resource_action.php" method="POST">
      <input type="hidden" name="action" value="create">
      <input name="name" placeholder="Nazwa" required>
      <input name="number" placeholder="Numer" required>
      <input name="category" placeholder="Kategoria" required>
      <input name="building" type="number" placeholder="Budynek" required>
      <input name="floor" type="number" placeholder="Pietro" required>
      <input name="room" type="number" placeholder="Sala" required>
      <select name="condition">
         <option value="sprawny">sprawny</option>
         <option value="uszkodzony">uszkodzony</option>
         <option value="do naprawy">do naprawy</option>
      </select>
      <select name="status">
         <option value="dostepny">dostepny</option>
         <option value="wypozyczony">wypozyczony</option>
      </select>
      <button type="submit">Dodaj</button>
   </form>
   <?php endif; ?>

   <table class="app-table">
      <thead>
         <tr><th>ID</th><th>Nazwa</th><th>Numer</th><th>Kategoria</th><th>Lokalizacja</th><th>Stan</th><th>Status</th><?php if (isAdmin()) echo '<th>Dzialania</th>'; ?></tr>
      </thead>
      <tbody>
      <?php foreach ($resources as $resource) : ?>
         <tr>
            <td><?php echo (int) $resource['ID']; ?></td>
            <td><?php echo esc($resource['Nazwa']); ?></td>
            <td><?php echo esc($resource['Numer']); ?></td>
            <td><?php echo esc($resource['Kategoria']); ?></td>
            <td><?php echo (int) $resource['Budynek'] . '/' . (int) $resource['Pietro'] . '/' . (int) $resource['Sala']; ?></td>
            <td><?php echo esc($resource['Stan']); ?></td>
            <td><?php echo esc($resource['Status']); ?></td>
            <?php if (isAdmin()) : ?>
            <td>
               <form action="../actions/resource_action.php" method="POST" class="app-form">
                  <input type="hidden" name="action" value="update">
                  <input type="hidden" name="id" value="<?php echo (int) $resource['ID']; ?>">
                  <input name="name" value="<?php echo esc($resource['Nazwa']); ?>">
                  <input name="number" value="<?php echo esc($resource['Numer']); ?>">
                  <input name="category" value="<?php echo esc($resource['Kategoria']); ?>">
                  <input name="building" type="number" value="<?php echo (int) $resource['Budynek']; ?>">
                  <input name="floor" type="number" value="<?php echo (int) $resource['Pietro']; ?>">
                  <input name="room" type="number" value="<?php echo (int) $resource['Sala']; ?>">
                  <select name="condition">
                     <option value="sprawny" <?php echo $resource['Stan'] === 'sprawny' ? 'selected' : ''; ?>>sprawny</option>
                     <option value="uszkodzony" <?php echo $resource['Stan'] === 'uszkodzony' ? 'selected' : ''; ?>>uszkodzony</option>
                     <option value="do naprawy" <?php echo $resource['Stan'] === 'do naprawy' ? 'selected' : ''; ?>>do naprawy</option>
                  </select>
                  <select name="status">
                     <option value="dostepny" <?php echo $resource['Status'] === 'dostepny' ? 'selected' : ''; ?>>dostepny</option>
                     <option value="wypozyczony" <?php echo $resource['Status'] === 'wypozyczony' ? 'selected' : ''; ?>>wypozyczony</option>
                  </select>
                  <button type="submit">Zapisz</button>
               </form>
               <form action="../actions/resource_action.php" method="POST" onsubmit="return confirm('Usunac zasob?');">
                  <input type="hidden" name="action" value="delete">
                  <input type="hidden" name="id" value="<?php echo (int) $resource['ID']; ?>">
                  <button type="submit">Usun</button>
               </form>
            </td>
            <?php endif; ?>
         </tr>
      <?php endforeach; ?>
      </tbody>
   </table>
</main>
</body>
</html>
