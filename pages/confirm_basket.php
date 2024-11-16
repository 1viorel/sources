<?php
session_start();
require_once "../includes/dbh.inc.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $pdo->beginTransaction();

        // Process basket
        if (isset($_SESSION["basket"]) && !empty($_SESSION["basket"])) {
            foreach ($_SESSION["basket"] as $item) {
                $id = $item['id']; // Use `id` from `produse`
                $quantity = $item['quantity'];

                // Check stock
                $stmt = $pdo->prepare("SELECT stoc FROM produse WHERE id = :id");
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$product || $product['stoc'] < $quantity) {
                    throw new Exception("Not enough stock for product ID: $id");
                }

                // Deduct stock
                $stmt = $pdo->prepare("UPDATE produse SET stoc = stoc - :quantity WHERE id = :id");
                $stmt->bindParam(":quantity", $quantity, PDO::PARAM_INT);
                $stmt->bindParam(":id", $id, PDO::PARAM_INT);
                $stmt->execute();

                // Add to achizitii
                $stmt = $pdo->prepare(
                    "INSERT INTO achizitii (id_utilizator, id_produs, cantitate, data_achizitie) 
                    VALUES (:id_utilizator, :id_produs, :cantitate, NOW())"
                );
                $stmt->bindParam(":id_utilizator", $_SESSION["user_id"], PDO::PARAM_INT);
                $stmt->bindParam(":id_produs", $id, PDO::PARAM_INT); // Use `id` here for `id_produs`
                $stmt->bindParam(":cantitate", $quantity, PDO::PARAM_INT);
                $stmt->execute();
            }

            unset($_SESSION["basket"]);
        }

        $pdo->commit();
        header("Location: ../index.php?achizitie=success");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $error = $e->getMessage();
    }
}

// Display basket for confirmation
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosul tau</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Cosul tau</h1>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($_SESSION["basket"]) && !empty($_SESSION["basket"])): ?>
        <div class="basket">
            <?php
            $total_price = 0;
            foreach ($_SESSION["basket"] as $item): 
                $total_price += $item['quantity'] * $item['valoare_unitara'];
            ?>
                <div class="basket-item">
                    <h3><?= htmlspecialchars($item['nume_produs']) ?></h3>
                    <p>Price: $<?= htmlspecialchars($item['valoare_unitara']) ?></p>
                    <p>Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                    <form method="POST" action="../includes/remove_from_basket.inc.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">
                        <button type="submit">Sterge</button>
                    </form>
                </div>
            <?php endforeach; ?>
            <p><strong>Total: $<?= $total_price ?></strong></p>
        </div>
        <form method="POST" action="confirm_basket.php">
            <button class="cta" type="submit">Confirma</button>
        </form>
        <a href="../index.php">Inapoi la Magazin</a>
    <?php else: ?>
        <p>Cos gol. <a href="../index.php">Inapoi</a>.</p>
    <?php endif; ?>
</body>
</html>
