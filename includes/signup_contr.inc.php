<?php

declare(strict_types=1);


function is_input_empty (string $nume, string $prenume, string $email, string $pwd, string $data_nasterii): bool {
    if (empty($nume) || empty($prenume) || empty($email) || empty($pwd) || empty($data_nasterii)) {
        return true;
    }
    return false;
}

function is_email_invalid (string $email): bool {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
    return false;
}

function is_email_taken (object $pdo, string $email): bool {
    if (get_email($pdo, $email)) return true;
    return false;
}


function is_birthday_invalid (string $data_nasterii): bool {
    $data_nasterii = explode("-", $data_nasterii);
    $an = (int)$data_nasterii[0];
    if ($an < 1900 || $an > 2021) return true;
    return false;
}

function create_user (object $pdo, string $nume, string $prenume, string $email, string $pwd, string $data_nasterii): void {
    $query = "INSERT INTO utilizatori (nume, prenume, email, pwd, data_nasterii) 
              VALUES (:nume, :prenume, :email, :pwd, :data_nasterii)";

    $options = [
        "cost" => 12,
    ];
    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":nume", $nume);
    $stmt->bindParam(":prenume", $prenume);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":pwd", $hashedPwd);
    $stmt->bindParam(":data_nasterii", $data_nasterii);
    $stmt->execute();
}