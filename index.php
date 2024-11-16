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



<!-- LOGOUT and HISTORY -->
<?php if (isset($_SESSION["user_id"])): ?>
    <nav class="navbar">
            <div>
                <form action="includes/logout.inc.php" method="post" class="navbar-form">
                    <button type="submit" class="orange">Logout</button>
                </form>
                <form method="GET" action="pages/history.php" class="navbar-form">
                    <button type="submit">Istoric Comenzi</button>
                </form>
                <form method="GET" action="pages/garantie.php" class="navbar-form">
                    <button type="submit" class="navbar-button">Produse in Garanție</button>
                </form>
            </div>
    </nav>
<?php endif; ?>

<h3>
    <?php
    output_username();
    ?>
</h3>

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
if (isset($_SESSION["user_id"])) {
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

            if ($product['stoc'] > 0) {
                echo "<form method='POST' action='includes/add_to_basket.inc.php'>
                        <input type='hidden' name='id' value='" . htmlspecialchars($product['id']) . "'>
                        <input type='hidden' name='nume_produs' value='" . htmlspecialchars($product['nume_produs']) . "'>
                        <input type='hidden' name='valoare_unitara' value='" . htmlspecialchars($product['valoare_unitara']) . "'>
                        <label for='quantity'>Cantitatea:</label>
                        <input type='number' name='quantity' value='1' min='1' max='" . htmlspecialchars($product['stoc']) . "'>
                        <button type='submit'>Adauga in cos</button>
                      </form>";
            } else {
                echo "<p>Nu e in stoc</p>";
            }
            echo "</div>";
        }
        echo "</div>";

        if (isset($_SESSION["basket"]) && !empty($_SESSION["basket"])) { ?>
             <form method='GET' action='pages/confirm_basket.php'>
                    <button type='submit'>Vezi cosul de cumparaturi</button>
                </form>
                <?php    
            };
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