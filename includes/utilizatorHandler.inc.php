<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "dbh.inc.php";

    // Common input
    $email = $_POST["email"] ?? null;

    try {
        // ADD User
        if (isset($_POST["action"]) && $_POST["action"] == "add") {
            $nume = $_POST["nume"];
            $prenume = $_POST["prenume"];
            $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT); // Hash the password
            $data_nasterii = $_POST["data_nasterii"];

            $query = "INSERT INTO utilizatori (nume, prenume, email, pwd, data_nasterii) 
                      VALUES (:nume, :prenume, :email, :pwd, :data_nasterii)";
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":nume", $nume);
            $stmt->bindParam(":prenume", $prenume);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":pwd", $pwd);
            $stmt->bindParam(":data_nasterii", $data_nasterii);
            $stmt->execute();

            header("Location: ../index.php");
            die();
        }

        // DELETE User
        if (isset($_POST["action"]) && $_POST["action"] == "delete") {
            $query = "DELETE FROM utilizatori WHERE email = :email";
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            header("Location: ../index.php");
            die();
        }

        // MODIFY User
        if (isset($_POST["action"]) && $_POST["action"] == "modify") {
            $nume = $_POST["nume"];
            $prenume = $_POST["prenume"];
            $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
            $data_nasterii = $_POST["data_nasterii"];

            $query = "UPDATE utilizatori SET nume = :nume, prenume = :prenume, pwd = :pwd, 
                      data_nasterii = :data_nasterii WHERE email = :email";
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":nume", $nume);
            $stmt->bindParam(":prenume", $prenume);
            $stmt->bindParam(":pwd", $pwd);
            $stmt->bindParam(":data_nasterii", $data_nasterii);
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            header("Location: ../index.php");
            die();
        }

    } catch (PDOException $e) {
        die("Operation failed: " . $e->getMessage());
    }

} elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    // SEARCH User
    if (isset($_GET["email"])) {
        require_once "dbh.inc.php";
        
        $email = $_GET["email"];
        
        try {
            $query = "SELECT * FROM utilizatori WHERE email = :email";
            
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Display user information or return it as JSON, depending on your needs
                echo json_encode($user);
            } else {
                echo "User not found.";
            }

        } catch (PDOException $e) {
            die("Search failed: " . $e->getMessage());
        }
    }
} else {
    header("Location: ../index.php");
}
