<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div>
        <h3>Adauga produs</h3>

        <form action="includes/produsHandler.inc.php" method="post">
            <input type="hidden" name="action" value="add">
            <input type="text" name="nume_produs" placeholder="Nume produs">
            <input type="text" name="descriere_produs" placeholder="Descriere produs">
            <input type="number" name="garantie" placeholder="Ani garantie">
            <input type="number" name="stoc" placeholder="Stoc">
            <input type="number" name="valoare_unitara" placeholder="Valoare unitara">
            <button>Adauga produs</button>
        </form>
    </div>
    <div>
        <h3>Șterge produs</h3>

        <form action="includes/produsHandler.inc.php" method="post">
            <input type="hidden" name="action" value="delete">
            <input type="text" name="nume_produs" placeholder="Nume produs pentru ștergere">
            <button>Șterge produs</button>
        </form>
    </div>

    <div>
        <h3>Modifică produs</h3>

        <form action="includes/produsHandler.inc.php" method="post">
            <input type="hidden" name="action" value="modify">    
            <input type="text" name="nume_produs" placeholder="Nume produs">
            <input type="text" name="descriere_produs" placeholder="Noua descriere">
            <input type="number" name="garantie" placeholder="Ani garanție">
            <input type="number" name="stoc" placeholder="Stoc">
            <input type="number" name="valoare_unitara" placeholder="Valoare unitară">
            <button>Modifică produs</button>
        </form>
    </div>

    <div>
        <h3>Caută produs</h3>

        <form action="includes/produsHandler.inc.php" method="get">
            <input type="hidden" name="action" value="search">
            <input type="text" name="nume_produs" placeholder="Nume produs pentru căutare">
            <button>Caută produs</button>
        </form>
    </div>
</body>
</html>