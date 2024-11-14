<?php
require_once "includes/signup_view.inc.php";
require_once "includes/login_view.inc.php";
require_once "includes/config_session.inc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h3>
    <?php
    output_username();
    ?>
</h3>

<!-- LOGOUT -->
 <?php
if (isset($_SESSION["user_id"])) { ?>
<form action="includes/logout.inc.php" method="post">
        <button type="submit">Logout</button>
</form>
<?php    
 };
 ?>

<!-- LOGIN -->
<?php 
 if (!isset($_SESSION["user_id"])) { ?>
    <h3>Login</h3>
    <form action="includes/login.inc.php" method="post">
        <input type="text" name="email" placeholder="Nume utlizator">
        <input type="password" name="pwd" placeholder="Parola">
        <button type="submit">Login</button>
    </form>
<?php    
 };
 check_login_errors();
 ?>

<!-- SIGNUP -->
<?php 
 if (!isset($_SESSION["user_id"])) { ?>
    <h1>sau</h1>
    <h3>Register</h3>
    <form action="includes/signup.inc.php" method="post">
        <?php
        signup_input();
        ?>
        <button type="submit">Register</button>
    </form>
    <?php    
 };
 check_signup_errors();
 ?>

  
<!-- CRUD -->
 
<?php
if (isset($_SESSION["user_id"])) { ?>
    <h3>(dev only: CRUD demonstration)</h3>
    <div class="link-container">
        <a href="pages/produse.php" class="dashboard-link">Produse</a>
        <a href="pages/utilizatori.php" class="dashboard-link">Utilizatori</a>
    </div>
    <?php    
 };
 ?>

</body>
</html>