<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <h3>Adauga produs</h3>

   <form action="includes/formhandler.inc.php" method="post">
        <input type="text" name="nume_produs" placeholder="Nume produs">
        <input type="text" name="descriere_produs" placeholder="Descriere produs">
        <input type="number" name="garantie" placeholder="Ani garantie">
        <input type="number" name="stoc" placeholder="Stoc">
        <input type="number" name="valoare_unitara" placeholder="Valoare unitara">
        <button>Adauga produs</button>
   </form>
</body>
</html>