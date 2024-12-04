<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>
<body>
    <!-- si l'utilisateur est connecté -->
    <?php if(isset($_SESSION["user"])){?>
        <a href="traitement.php?action=logout">Deconnexion</a>
        <a href="traitement.php?action=profil">Profil</a>
    <?php } else { ?> 
        <a href="login.php">Connexion</a> 
        <a href="register.php">Inscription</a>
    <?php } ?> 
    <h1>Accueil</h1>
        <?php if (isset($_SESSION["user"])){
            echo "<p>Bonjour " . $_SESSION["user"]["pseudo"]."</p>";
        } ?>
</body>
</html>