<?php

declare(strict_types=1);


function is_input_empty (string $nume, string $prenume, string $email, string $pwd, string $data_nasterii): bool {
    if (empty($nume) || empty($prenume) || empty($email) || empty($pwd) || empty($data_nasterii)) {
        return true;
    }
    return false;
}

function is_email_valid (string $email): bool {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return true;
    return false;
}

function is_email_taken (object $pdo, string $email): bool {
    if (get_email($pdo, $email)) return true;
    return false;
}