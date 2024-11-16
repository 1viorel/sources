<?php
session_start();
require_once "../includes/dbh.inc.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    die();
}

$user_id = $_SESSION["user_id"];

try {
    $query = "
        SELECT 
            produse.nume_produs AS Produs,
            achizitii.cantitate AS Cantitate,
            (achizitii.cantitate * produse.valoare_unitara) AS ValoareTotala
        FROM 
            achizitii
        INNER JOIN utilizatori ON achizitii.id_utilizator = utilizatori.id
        INNER JOIN produse ON achizitii.id_produs = produse.id
        WHERE 
            achizitii.id_utilizator = :user_id
        ORDER BY 
            achizitii.data_achizitie DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Failed to fetch purchase history: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Istoric Comenzi</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Istoric Comenzi</h1>

    <?php if (!empty($history)): ?>
        <table>
            <thead>
                <tr>
                    <th>Produs</th>
                    <th>Cantitate</th>
                    <th>Valoare Totala</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($history as $entry): ?>
                    <tr>
                        <td><?= htmlspecialchars($entry['Produs']) ?></td>
                        <td><?= htmlspecialchars($entry['Cantitate']) ?></td>
                        <td>$<?= htmlspecialchars(number_format($entry['ValoareTotala'], 2)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nu aveți nicio comandă înregistrată.</p>
    <?php endif; ?>

    <a href="../index.php">Inapoi la Magazin</a>
</body>
</html>
