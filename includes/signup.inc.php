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

        $error = [];
        if(is_input_empty( $nume, $prenume, $email, $pwd, $data_nasterii)) $error["spatiu_gol"] = "Toate campurile sunt obligatorii!";
        if (is_email_invalid($email)) $error["email_invalid"] = "Email invalid!";
        if (is_email_taken($pdo, $email)) $error["email_luat"] = "Email-ul este deja folosit!";
        if (is_birthday_invalid($data_nasterii)) $error["zi_de_nastere_invalida"] = "Data nasterii invalida!";

        require_once "config_session.inc.php";

        if ($error) {
            $_SESSION["error_signup"] = $error;

            $signup_data = [
                "nume" => $nume,
                "prenume" => $prenume,
                "email" => $email,
                "data_nasterii" => $data_nasterii,
            ];
            $_SESSION["signup_data"] = $signup_data;

            header("Location:  ../index.php");
            die();
        }

        create_user($pdo, $nume, $prenume, $email, $pwd, $data_nasterii);
        header("Location: ../index.php?signup=succes");
        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        die("Eroare query: " . $e->getMessage());
    }

} else {
    header("Location: ../index.php");
    exit();
}

