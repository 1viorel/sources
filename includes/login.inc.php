<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

    try {
        require_once "dbh.inc.php";
        require_once "login_model.inc.php";
        require_once "login_contr.inc.php";

        $error = [];
        if(is_input_empty($email, $pwd)) $error["spatiu_gol"] = "Toate campurile sunt obligatorii!";

        $result = get_user($pdo, $email);

        if (is_email_wrong($result))  $error["email_gresit"] = "Nu exista cont cu acest email!";
        else if (is_pwd_wrong($pwd, $result["pwd"])) $error["parola_gresita"] = "Parola gresita!";        

        require_once "config_session.inc.php";

        if ($error) {
            $_SESSION["error_login"] = $error;

            header("Location:  ../index.php");
            die();
        }
        $_SESSION["user_id"] = $result["id"];
        $_SESSION["user_email"] = htmlspecialchars($result["email"]);
        
        header("Location: ../index.php?login=success");
        $pdo = null;
        $stmt = null;
        die();
    } catch (PDOException $e) {
        die("Eroare query: " . $e->getMessage());
    }
} else {
    header("Location: ../index.php");
    die();
}