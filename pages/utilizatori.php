<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="form-container">
        <h3>Adaugă utilizator</h3>
        <form action="../includes/utilizatorHandler.inc.php" method="post">
            <input type="hidden" name="action" value="add">
            <input type="text" name="nume" placeholder="Nume">
            <input type="text" name="prenume" placeholder="Prenume">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="pwd" placeholder="Parolă">
            <input type="date" name="data_nasterii" placeholder="Data nașterii">
            <button>Adaugă utilizator</button>
        </form>
    </div>
    
    <div class="form-container">
        <h3>Șterge utilizator</h3>
        <form action="../includes/utilizatorHandler.inc.php" method="post">
            <input type="hidden" name="action" value="delete">
            <input type="email" name="email" placeholder="Email pentru ștergere">
            <button>Șterge utilizator</button>
        </form>
    </div>

    <div class="form-container">
        <h3>Modifică utilizator</h3>
        <form action="../includes/utilizatorHandler.inc.php" method="post">
            <input type="hidden" name="action" value="modify">
            <input type="email" name="email" placeholder="Email">
            <input type="text" name="nume" placeholder="Nume nou">
            <input type="text" name="prenume" placeholder="Prenume nou">
            <input type="password" name="pwd" placeholder="Parolă nouă">
            <input type="date" name="data_nasterii" placeholder="Data nașterii nouă">
            <button>Modifică utilizator</button>
        </form>
    </div>

    <div class="form-container">
        <h3>Caută utilizator</h3>
        <form action="../includes/utilizatorHandler.inc.php" method="get">
            <input type="email" name="email" placeholder="Email pentru căutare">
            <button>Caută utilizator</button>
        </form>
    </div>
</body>
</html>
