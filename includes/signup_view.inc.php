<?php

declare(strict_types=1);

function signup_input() {
    // Check for 'nume' data in session and display the input accordingly
    if (isset($_SESSION["signup_data"]["nume"])) {
        echo '<input type="text" name="nume" placeholder="Nume" value="' . htmlspecialchars($_SESSION["signup_data"]["nume"]) . '">';
    } else {
        echo '<input type="text" name="nume" placeholder="Nume">';
    }

    // Check for 'prenume' data in session and display the input accordingly
    if (isset($_SESSION["signup_data"]["prenume"])) {
        echo '<input type="text" name="prenume" placeholder="Prenume" value="' . htmlspecialchars($_SESSION["signup_data"]["prenume"]) . '">';
    } else {
        echo '<input type="text" name="prenume" placeholder="Prenume">';
    }

    // Check for 'email' data in session and display the input accordingly
    if (isset($_SESSION["signup_data"]["email"])) {
        echo '<input type="text" name="email" placeholder="Email" value="' . htmlspecialchars($_SESSION["signup_data"]["email"]) . '">';
    } else {
        echo '<input type="text" name="email" placeholder="Email">';
    }

    // Password field (no value should be set for security reasons)
    echo '<input type="password" name="pwd" placeholder="Parola">';

    // Check for 'data_nasterii' data in session and display the input accordingly
    if (isset($_SESSION["signup_data"]["data_nasterii"])) {
        echo '<input type="date" name="data_nasterii" placeholder="Data nasterii" value="' . htmlspecialchars($_SESSION["signup_data"]["data_nasterii"]) . '">';
    } else {
        echo '<input type="date" name="data_nasterii" placeholder="Data nasterii">';
    }
}


function check_signup_errors() {
    if (isset($_SESSION["error_signup"])) {
        $error = $_SESSION["error_signup"];
        foreach ($error as $key => $value) {
            echo "<p class='error'>$value</p>";
        }
        unset($_SESSION["error_signup"]);
    } else if(isset($_GET["signup"]) && $_GET["signup"] == "succes") {
        echo "<br>";
        echo "<p class='success'>Contul a fost creat cu success!</p>";
    }
}