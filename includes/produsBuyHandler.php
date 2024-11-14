<?php
session_start();
require_once "dbh.inc.php"; // Database connection

// Check if the request is POST and the "buy" action is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]) && $_POST["action"] == "buy") {
    // Ensure the user is logged in and product data is provided
    if (isset($_SESSION["user_id"]) && isset($_POST["nume_produs"])) {
        $nume_produs = $_POST["nume_produs"];

        try {
            // Check the product's current stock
            $query = "SELECT stoc FROM produse WHERE nume_produs = :nume_produs";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":nume_produs", $nume_produs);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product && $product['stoc'] > 0) {
                // If the product is in stock, reduce stock by 1
                $new_stock = $product['stoc'] - 1;
                $update_query = "UPDATE produse SET stoc = :new_stock WHERE nume_produs = :nume_produs";
                $update_stmt = $pdo->prepare($update_query);
                $update_stmt->bindParam(":new_stock", $new_stock);
                $update_stmt->bindParam(":nume_produs", $nume_produs);
                $update_stmt->execute();

                // Redirect to index.php with a success message
                header("Location: ../index.php?purchase=success");
                exit();
            } else {
                // Redirect to index.php with an out-of-stock message
                header("Location: ../index.php?purchase=out_of_stock");
                exit();
            }

        } catch (PDOException $e) {
            // Handle any errors with the database interaction
            die("Purchase operation failed: " . $e->getMessage());
        }
    } else {
        // Redirect to index.php if there is no user logged in or product specified
        header("Location: ../index.php?purchase=out_of_stock");
        exit();
    }
} else {
    // Redirect to index.php if the request is not valid
    header("Location: ../index.php");
    exit();
}
?>
