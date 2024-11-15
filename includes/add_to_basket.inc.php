<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"], $_POST["quantity"])) {
    $id = $_POST["id"];
    $nume_produs = $_POST["nume_produs"];
    $valoare_unitara = $_POST["valoare_unitara"];
    $quantity = intval($_POST["quantity"]);

    if (!isset($_SESSION["basket"])) {
        $_SESSION["basket"] = [];
    }

    $found = false;
    foreach ($_SESSION["basket"] as &$item) {
        if ($item["id"] == $id) {
            $item["quantity"] += $quantity; 
            $found = true;
            break;
        }
    }

    if (!$found) {
        $_SESSION["basket"][] = [
            "id" => $id,
            "nume_produs" => $nume_produs,
            "valoare_unitara" => $valoare_unitara,
            "quantity" => $quantity
        ];
    }

    header("Location: ../index.php?added_to_basket=true");
    die();
} else {
    header("Location: ../index.php");
    die();
}
