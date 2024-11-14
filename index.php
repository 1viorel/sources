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

<!-- PRODUSE -->
<?php
if (isset($_SESSION["user_id"]) && $_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET["nume_produs"])) {
    require_once "includes/dbh.inc.php";

    try {
        $query = "SELECT * FROM produse";
        $stmt = $pdo->query($query);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo "<h2>SHOP</h2><div class='product-list'>";
        foreach ($products as $product) {
            echo "<div class='product-item'>";
            echo "<h3>" . htmlspecialchars($product['nume_produs']) . "</h3>";
            echo "<p>Description: " . htmlspecialchars($product['descriere_produs']) . "</p>";
            echo "<p>Price: $" . htmlspecialchars($product['valoare_unitara']) . "</p>";
            echo "<p>Stock: " . htmlspecialchars($product['stoc']) . "</p>";
            
            // Display Buy button if stock is available
            if ($product['stoc'] > 0) {
                echo "<form method='POST' action='includes/produsBuyHandler.php'>
                        <input type='hidden' name='nume_produs' value='" . htmlspecialchars($product['nume_produs']) . "'>
                        <input type='hidden' name='action' value='buy'>
                        <button type='submit'>Buy</button>
                      </form>";
            } else {
                echo "<p><em>Out of Stock</em></p>";
            }
            echo "</div>";
        }
        echo "</div>";

    } catch (PDOException $e) {
        die("Failed to retrieve products: " . $e->getMessage());
    }
}
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