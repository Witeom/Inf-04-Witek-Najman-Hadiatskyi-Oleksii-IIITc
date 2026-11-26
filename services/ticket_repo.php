<?php

function getTickets($pdo)
{
    $statement = $pdo->query(
        'SELECT t.*, z.Nazwa, z.Numer, u.Imie, u.Nazwisko
         FROM tickety t
         JOIN zasoby_szkolne z ON z.ID = t.Zasob_ID
         JOIN uzytkownicy u ON u.ID = t.Autor_ID
         ORDER BY t.Data_Utworzenia DESC'
    );
    return $statement->fetchAll();
}

function createTicket($pdo, $resourceId, $userId, $type, $description)
{
    $statement = $pdo->prepare(
        'SELECT Budynek, Pietro, Sala FROM zasoby_szkolne WHERE ID = :id'
    );
    $statement->execute(['id' => $resourceId]);
    $resource = $statement->fetch();

    if (!$resource) {
        return false;
    }

    $statement = $pdo->prepare(
        'INSERT INTO tickety
         (Zasob_ID, Autor_ID, Typ_Problemu, Opis, Status_Ticketu, Budynek, Pietro, Sala)
         VALUES (:resource, :author, :type, :description, :status, :building, :floor, :room)'
    );
    $statement->execute([
        'resource' => $resourceId,
        'author' => $userId,
        'type' => $type,
        'description' => $description,
        'status' => 'otwarty',
        'building' => $resource['Budynek'],
        'floor' => $resource['Pietro'],
        'room' => $resource['Sala'],
    ]);
    return true;
}

function closeTicket($pdo, $ticketId)
{
    $statement = $pdo->prepare(
        "UPDATE tickety
         SET Status_Ticketu = 'zamkniety', Data_Zamkniecia = NOW()
         WHERE ID = :id"
    );
    $statement->execute(['id' => (int) $ticketId]);
}
