<?php

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nume_produs = $_POST["nume_produs"];
    $descriere_produs = $_POST["descriere_produs"];
    $garantie = $_POST["garantie"];
    $stoc = $_POST["stoc"];
    $valoare_unitara = $_POST["valoare_unitara"];


    try {
        require_once "dbh.inc.php";

        $query = "INSERT INTO produse (nume_produs, descriere_produs, garantie, stoc, valoare_unitara) VALUES 
        (:nume_produs, :descriere_produs, :garantie, :stoc, :valoare_unitara);";

        $stmt = $pdo->prepare($query);

        // this is used to prevent sql injection attacks
        $stmt->bindParam(":nume_produs",$nume_produs);
        $stmt->bindParam(":descriere_produs",$descriere_produs);
        $stmt->bindParam(":garantie",$garantie);
        $stmt->bindParam(":stoc",$stoc);
        $stmt->bindParam(":valoare_unitara",$valoare_unitara);

        $stmt->execute();

        $pdo = null;
        $stmt = null;

        header("Location: ../index.php");
        die();
    } catch(PDOException $e) {
        die("Upload product failed ". $e->getMessage());
    }
} else{
    header("Location: ../index.php");
}