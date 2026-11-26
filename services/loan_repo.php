<?php

function getLoans($pdo)
{
    $statement = $pdo->query(
        'SELECT w.*, z.Nazwa, z.Numer, u.Imie, u.Nazwisko
         FROM wyporzyczenia w
         JOIN zasoby_szkolne z ON z.ID = w.Zasob_ID
         JOIN uzytkownicy u ON u.ID = w.Uzytkownik_ID
         ORDER BY w.Data_Wypozyczenia DESC, w.ID DESC'
    );
    return $statement->fetchAll();
}

function issueResource($pdo, $resourceId, $userId, $dueDate)
{
    $pdo->beginTransaction();
    $statement = $pdo->prepare(
        'SELECT Status FROM zasoby_szkolne WHERE ID = :id FOR UPDATE'
    );
    $statement->execute(['id' => $resourceId]);
    $resource = $statement->fetch();

    if (!$resource || $resource['Status'] !== 'dostepny') {
        $pdo->rollBack();
        return false;
    }

    $statement = $pdo->prepare(
        'INSERT INTO wyporzyczenia
         (Zasob_ID, Uzytkownik_ID, Data_Wypozyczenia, Przewidywana_data_zwrotu, Status_Wypozyczenia)
         VALUES (:resource, :user, CURDATE(), :due, :status)'
    );
    $statement->execute([
        'resource' => $resourceId,
        'user' => $userId,
        'due' => $dueDate,
        'status' => 'aktywne',
    ]);

    $statement = $pdo->prepare(
        "UPDATE zasoby_szkolne SET Status = 'wypozyczony' WHERE ID = :id"
    );
    $statement->execute(['id' => $resourceId]);

    $statement = $pdo->prepare(
        'UPDATE uzytkownicy SET ilosc_wypozyczen = ilosc_wypozyczen + 1 WHERE ID = :id'
    );
    $statement->execute(['id' => $userId]);
    $pdo->commit();
    return true;
}

function returnResource($pdo, $loanId)
{
    $pdo->beginTransaction();
    $statement = $pdo->prepare(
        'SELECT Zasob_ID FROM wyporzyczenia
         WHERE ID = :id AND Status_Wypozyczenia = :status'
    );
    $statement->execute(['id' => $loanId, 'status' => 'aktywne']);
    $loan = $statement->fetch();

    if (!$loan) {
        $pdo->rollBack();
        return false;
    }

    $statement = $pdo->prepare(
        "UPDATE wyporzyczenia
         SET Data_Zwrotu = CURDATE(), Status_Wypozyczenia = 'zwrocone'
         WHERE ID = :id"
    );
    $statement->execute(['id' => $loanId]);
    $statement = $pdo->prepare(
        "UPDATE zasoby_szkolne SET Status = 'dostepny' WHERE ID = :id"
    );
    $statement->execute(['id' => $loan['Zasob_ID']]);
    $pdo->commit();
    return true;
}
