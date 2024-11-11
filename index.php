<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h3>Login</h3>
    <form action="includes/login.inc.php" method="post">
        <input type="text" name="email" placeholder="Nume utlizator">
        <input type="password" name="pwd" placeholder="Parola">
        <button type="submit">Login</button>
    </form>

    <h3>Register</h3>
    <form action="includes/signup.inc.php" method="post">
        <input type="text" name="nume" placeholder="Nume">
        <input type="text" name="prenume" placeholder="Prenume">
        <input type="text" name="email" placeholder="Email">
        <input type="password" name="pwd" placeholder="Parola">
        <input type="date" name="data_nasterii" placeholder="Data nasterii">
        <button type="submit">Register</button>
    </form>

    <h3>Pagina principala</h3>
    <div class="link-container">
        <a href="pages/produse.php" class="dashboard-link">Produse</a>
        <a href="pages/utilizatori.php" class="dashboard-link">Utilizatori</a>
    </div>
</body>
</html>