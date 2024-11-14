<?php

declare(strict_types=1);

function output_username() {
    if (isset($_SESSION["user_id"])) {
        $user_nume = $_SESSION["user_nume"];
        $user_prenume = $_SESSION["user_prenume"];
        echo "<p class='success'> Bine ai venit, $user_nume $user_prenume! </p>";
    } else {
        echo "<p class='error'>Nu esti logat! </p>";
    }
}

function check_login_errors() {
    if (isset($_SESSION["error_login"])) {
        $error = $_SESSION["error_login"];
        foreach ($error as $key => $value) {
            echo "<p class='error'>$value</p>";
        }
        unset($_SESSION["error_login"]);
    } 
    else if(isset($_GET["login"])&& $_GET["login"] === "success") {
        echo "<br>";
        echo "<p class='success'>Logare cu succes!</p>";
    }
}


