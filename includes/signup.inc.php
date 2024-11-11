<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $nume = $_POST["nume"];
    $prenume = $_POST["prenume"];
    $data_nasterii = $_POST["data_nasterii"];

    try {
        require_once "dbh.inc.php";
        require_once "signup_model.inc.php";
        require_once "signup_contr.inc.php";

        if(is_input_empty( $nume, $prenume, $email, $pwd, $data_nasterii)) {
            header("Location: ../signup_view.inc.php?error=emptyinput");
            exit();
        }

        if (!is_email_valid($email)) {
            header("Location: ../signup_view.inc.php?error=invalidemail");
            exit();
        }

        if (is_email_taken($pdo, $email)) {
            header("Location: ../signup_view.inc.php?error=emailtaken");
            exit();
        }

    } catch (PDOException $e) {
        die("Eroare query: " . $e->getMessage());
    }

} else {
    header("Location: ../index.php");
    exit();
}