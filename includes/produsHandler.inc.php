<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "dbh.inc.php";

    // Common input
    $nume_produs = $_POST["nume_produs"] ?? null;

    try {
        // ADD Product
        if (isset($_POST["action"]) && $_POST["action"] == "add") {
            $descriere_produs = $_POST["descriere_produs"];
            $garantie = $_POST["garantie"];
            $stoc = $_POST["stoc"];
            $valoare_unitara = $_POST["valoare_unitara"];

            $query = "INSERT INTO produse (nume_produs, descriere_produs, garantie, stoc, valoare_unitara) 
                      VALUES (:nume_produs, :descriere_produs, :garantie, :stoc, :valoare_unitara)";
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":nume_produs", $nume_produs);
            $stmt->bindParam(":descriere_produs", $descriere_produs);
            $stmt->bindParam(":garantie", $garantie);
            $stmt->bindParam(":stoc", $stoc);
            $stmt->bindParam(":valoare_unitara", $valoare_unitara);
            $stmt->execute();

            header("Location: ../index.php");
            die();
        }

        // DELETE Product
        if (isset($_POST["action"]) && $_POST["action"] == "delete") {
            $query = "DELETE FROM produse WHERE nume_produs = :nume_produs";
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":nume_produs", $nume_produs);
            $stmt->execute();

            header("Location: ../index.php");
            die();
        }

        // MODIFY Product
        if (isset($_POST["action"]) && $_POST["action"] == "modify") {
            $descriere_produs = $_POST["descriere_produs"];
            $garantie = $_POST["garantie"];
            $stoc = $_POST["stoc"];
            $valoare_unitara = $_POST["valoare_unitara"];

            $query = "UPDATE produse SET descriere_produs = :descriere_produs, garantie = :garantie, 
                      stoc = :stoc, valoare_unitara = :valoare_unitara WHERE nume_produs = :nume_produs";
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":nume_produs", $nume_produs);
            $stmt->bindParam(":descriere_produs", $descriere_produs);
            $stmt->bindParam(":garantie", $garantie);
            $stmt->bindParam(":stoc", $stoc);
            $stmt->bindParam(":valoare_unitara", $valoare_unitara);
            $stmt->execute();

            header("Location: ../index.php");
            die();
        }

    } catch (PDOException $e) {
        die("Operation failed: " . $e->getMessage());
    }

} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // SEARCH Product
    if (isset($_GET["nume_produs"])) {
        require_once "dbh.inc.php";
        
        $nume_produs = $_GET["nume_produs"];
        
        try {
            $query = "SELECT * FROM produse WHERE nume_produs = :nume_produs";
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":nume_produs", $nume_produs);
            $stmt->execute();
            
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                // Display product information or return it as JSON, depending on your needs
                echo json_encode($product);
            } else {
                echo "Product not found.";
            }

        } catch (PDOException $e) {
            die("Search failed: " . $e->getMessage());
        }
    }
} else {
    header("Location: ../index.php");
}

