<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
    $id_produs = $_POST["id"];

    if (isset($_SESSION["basket"])) {
        foreach ($_SESSION["basket"] as $key => $item) {
            if ($item["id"] == $id_produs) {
                unset($_SESSION["basket"][$key]); // Remove item
                break;
            }
        }

        $_SESSION["basket"] = array_values($_SESSION["basket"]); // Re-index the array
    }

    header("Location: ../index.php");
    die();
} else {
    header("Location: ../index.php");
    die();
}
