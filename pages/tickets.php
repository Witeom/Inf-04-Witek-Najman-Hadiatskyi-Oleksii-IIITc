<?php
require_once __DIR__ . '/../auth/guard.php';
require_once __DIR__ . '/../services/ticket_repo.php';
requireLogin();

$tickets = getTickets($pdo);
$resources = $pdo->query('SELECT ID, Nazwa, Numer FROM zasoby_szkolne ORDER BY Nazwa')->fetchAll();

function escTicket($value)
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
   <meta charset="UTF-8">
   <title>Zgloszenia</title>
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
   <h1>Zgloszenia problemow</h1>
   <h2>Dodaj zgloszenie</h2>
   <form class="app-form" action="../actions/ticket_action.php" method="POST">
      <input type="hidden" name="action" value="create">
      <select name="resource_id" required>
         <option value="">Wybierz zasob</option>
         <?php foreach ($resources as $resource) : ?>
         <option value="<?php echo (int) $resource['ID']; ?>"><?php echo escTicket($resource['Nazwa'] . ' - ' . $resource['Numer']); ?></option>
         <?php endforeach; ?>
      </select>
      <select name="type">
         <option value="nie_wiem">Nie wiem</option>
         <option value="uszkodzenie">Uszkodzenie</option>
         <option value="awaria">Awaria</option>
         <option value="brak_elementu">Brak elementu</option>
      </select>
      <textarea name="description" rows="4" cols="50" placeholder="Opis problemu" required></textarea>
      <button type="submit">Zglos</button>
   </form>

   <table class="app-table">
      <thead><tr><th>Zasob</th><th>Autor</th><th>Typ</th><th>Opis</th><th>Status</th><th>Data</th><?php if (isAdmin()) echo '<th>Dzialanie</th>'; ?></tr></thead>
      <tbody>
      <?php foreach ($tickets as $ticket) : ?>
      <tr>
         <td><?php echo escTicket($ticket['Nazwa'] . ' (' . $ticket['Numer'] . ')'); ?></td>
         <td><?php echo escTicket($ticket['Imie'] . ' ' . $ticket['Nazwisko']); ?></td>
         <td><?php echo escTicket($ticket['Typ_Problemu']); ?></td>
         <td><?php echo escTicket($ticket['Opis']); ?></td>
         <td><?php echo escTicket($ticket['Status_Ticketu']); ?></td>
         <td><?php echo escTicket($ticket['Data_Utworzenia']); ?></td>
         <?php if (isAdmin() && $ticket['Status_Ticketu'] === 'otwarty') : ?>
         <td>
            <form action="../actions/ticket_action.php" method="POST">
               <input type="hidden" name="action" value="close">
               <input type="hidden" name="ticket_id" value="<?php echo (int) $ticket['ID']; ?>">
               <button type="submit">Zamknij</button>
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
