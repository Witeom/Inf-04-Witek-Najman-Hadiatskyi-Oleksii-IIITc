<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../services/loan_repo.php';
requireLogin();

$loans = getLoans($pdo);
$available = $pdo->query("SELECT ID, Nazwa, Numer FROM zasoby_szkolne WHERE Status = 'dostepny' ORDER BY Nazwa")->fetchAll();
$users = $pdo->query('SELECT ID, Imie, Nazwisko, Login FROM uzytkownicy ORDER BY Nazwisko, Imie')->fetchAll();

function escLoan($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <title>Wypozyczenia</title>
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
   <h1>Wypozyczenia i zwroty</h1>
   <?php if (isAdmin()) : ?>
   <h2>Wypozycz zasob</h2>
   <form class="app-form" action="../actions/loan_action.php" method="POST">
      <input type="hidden" name="action" value="issue">
      <select name="resource_id" required>
         <option value="">Wybierz zasob</option>
         <?php foreach ($available as $resource) : ?>
         <option value="<?php echo (int) $resource['ID']; ?>"><?php echo escLoan($resource['Nazwa'] . ' - ' . $resource['Numer']); ?></option>
         <?php endforeach; ?>
      </select>
      <select name="user_id" required>
         <option value="">Wybierz uzytkownika</option>
         <?php foreach ($users as $user) : ?>
         <option value="<?php echo (int) $user['ID']; ?>"><?php echo escLoan($user['Imie'] . ' ' . $user['Nazwisko'] . ' (' . $user['Login'] . ')'); ?></option>
         <?php endforeach; ?>
      </select>
      <input type="date" name="due_date" required>
      <button type="submit">Wypozycz</button>
   </form>
   <?php endif; ?>

   <table class="app-table">
      <thead><tr><th>Zasob</th><th>Uzytkownik</th><th>Wypozyczono</th><th>Zwrot przewidywany</th><th>Status</th><?php if (isAdmin()) echo '<th>Dzialanie</th>'; ?></tr></thead>
      <tbody>
      <?php foreach ($loans as $loan) : ?>
      <tr>
         <td><?php echo escLoan($loan['Nazwa'] . ' (' . $loan['Numer'] . ')'); ?></td>
         <td><?php echo escLoan($loan['Imie'] . ' ' . $loan['Nazwisko']); ?></td>
         <td><?php echo escLoan($loan['Data_Wypozyczenia']); ?></td>
         <td><?php echo escLoan($loan['Przewidywana_data_zwrotu']); ?></td>
         <td><?php echo escLoan($loan['Status_Wypozyczenia']); ?></td>
         <?php if (isAdmin() && $loan['Status_Wypozyczenia'] === 'aktywne') : ?>
         <td>
            <form action="../actions/loan_action.php" method="POST">
               <input type="hidden" name="action" value="return">
               <input type="hidden" name="loan_id" value="<?php echo (int) $loan['ID']; ?>">
               <button type="submit">Zwroc</button>
            </form>
         </td>
         <?php elseif (isAdmin()) : ?>
         <td>-</td>
         <?php endif; ?>
      </tr>
      <?php endforeach; ?>
      </tbody>
   </table>
</main>
</body>
</html>
