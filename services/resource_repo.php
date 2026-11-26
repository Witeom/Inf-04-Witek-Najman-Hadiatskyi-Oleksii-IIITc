<?php

function getResources($pdo, $search = '', $category = '')
{
    $sql = 'SELECT * FROM zasoby_szkolne WHERE 1=1';
    $params = [];

    if ($search !== '') {
        $sql .= ' AND (Nazwa LIKE :search OR Numer LIKE :search)';
        $params['search'] = '%' . $search . '%';
    }
    if ($category !== '') {
        $sql .= ' AND Kategoria = :category';
        $params['category'] = $category;
    }

    $sql .= ' ORDER BY Nazwa, Numer';
    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    return $statement->fetchAll();
}

function createResource($pdo, $data)
{
    $statement = $pdo->prepare(
        'INSERT INTO zasoby_szkolne
         (Nazwa, Numer, Kategoria, Budynek, Pietro, Sala, Stan, Status)
         VALUES (:name, :number, :category, :building, :floor, :room, :condition, :status)'
    );
    $statement->execute([
        'name' => $data['name'],
        'number' => $data['number'],
        'category' => $data['category'],
        'building' => (int) $data['building'],
        'floor' => (int) $data['floor'],
        'room' => (int) $data['room'],
        'condition' => $data['condition'],
        'status' => $data['status'],
    ]);
}

function updateResource($pdo, $id, $data)
{
    $statement = $pdo->prepare(
        'UPDATE zasoby_szkolne SET
         Nazwa = :name, Numer = :number, Kategoria = :category,
         Budynek = :building, Pietro = :floor, Sala = :room,
         Stan = :condition, Status = :status
         WHERE ID = :id'
    );
    $statement->execute([
        'id' => (int) $id,
        'name' => $data['name'],
        'number' => $data['number'],
        'category' => $data['category'],
        'building' => (int) $data['building'],
        'floor' => (int) $data['floor'],
        'room' => (int) $data['room'],
        'condition' => $data['condition'],
        'status' => $data['status'],
    ]);
}

function deleteResource($pdo, $id)
{
    $statement = $pdo->prepare('DELETE FROM zasoby_szkolne WHERE ID = :id');
    $statement->execute(['id' => (int) $id]);
}
