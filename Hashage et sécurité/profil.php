<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Mon profil</h1>
    <?php if(isset($_SESSION["user"])){
        $infoSession = $_SESSION["user"];
    }?>
    <p>pseudo : <?php $infoSession["pseudo"] ?></p>
    <p>Email : <?php $infoSession["email"] ?></p>
</body>
</html>