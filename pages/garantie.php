<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

require_once "../includes/dbh.inc.php";

try {
    $query = "
        SELECT 
            p.nume_produs AS Produs,
            DATE_ADD(a.data_achizitie, INTERVAL p.garantie MONTH) AS DataExpirarii
        FROM achizitii a
        JOIN produse p ON a.id_produs = p.id
        WHERE DATE_ADD(a.data_achizitie, INTERVAL p.garantie MONTH) > CURDATE()
        ORDER BY DataExpirarii ASC;
    ";

    $stmt = $pdo->query($query);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Failed to retrieve products under warranty: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produse in Garantie</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="report-container">
        <h1>Produse in Garantie</h1>
        <?php if (count($products) > 0): ?>
            <table class="report-table">
                <thead>
                    <tr>
                        <th>Produs</th>
                        <th>Data Expirarii</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product["Produs"]); ?></td>
                            <td><?php echo htmlspecialchars($product["DataExpirarii"]); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="../index.php">Inapoi la Magazin</a>
        <?php else: ?>
            <p>Nu exista produse aflate in perioada de garantie.</p>
        <?php endif; ?>
    </div>
</body>
</html>
