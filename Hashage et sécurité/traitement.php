<?php
session_start();
if(isset($_GET["action"])) {
    switch($_GET["action"]){
        case'register': 
            
            // Connexion à la DB
            $pdo = new PDO("mysql::host=localhost;dbname=forum_giacomo;charset=utf8", "root", "");
            // Filtrage des données entrées
            $pseudo= filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $pass1= filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2= filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            if($pseudo && $email && $pass1 && $pass2) {
                $request = $pdo->prepare("SELECT * FROM user WHERE email = :email");
                $request -> execute(["email" => $email]);
                $user = $request -> fetch();
                
                if($user){
                    header("location: register.php"); exit;
                } else {
                    // insertion de l'utilisateur en base de données
                    if($pass1 == $pass2 && strlen($pass1) >= 5) {
                        $insertUser = $pdo->prepare("INSERT INTO user (pseudo, email, password) VALUES (:pseudo, :email, :password)");
                        $insertUser->execute ([
                            'pseudo' => $pseudo,
                            'email' => $email,
                            // récupération hashée du password filtré et confirmé 
                            'password' => password_hash($pass1, PASSWORD_DEFAULT)
                        ]);
                        header("location: login.php"); exit;
                    }
                }
                
            } else {
                echo "Il y a un problème de saisie !";
            } 
            header("location: register.php");exit;
            break;
            
            case 'login': 
                if(isset($_POST["submit"])){
                
                // Connexion à la DB
                $pdo = new PDO("mysql::host=localhost;dbname=forum_giacomo;charset=utf8", "root", "");
                // Filtrer les champs
                $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                $password= filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                
                // Si les filtres sont corrects
                if ($email && $password) {
                    $request = $pdo->prepare("SELECT * FROM user WHERE email = :email");
                    $request -> execute(['email' => $email]);
                    $user = $request->fetch();

                    // est ce que l'utilisateur existe ? 
                    if($user){
                        $hash = $user["password"];
                        if(password_verify($password, $hash)){
                            $_SESSION["user"] = $user;
                            header("location: home.php"); exit;
                        } else {
                            header("location: login.php"); exit;
                        }
                    } else {
                        echo "L'utilisateur n'existe pas !";
                    }
                }
            }
            header("location: login.php");exit;
            break;

            case 'profile': 
                header("Location: profil.php"); exit;
            break;

            case 'logout':
                unset($_SESSION["user"]);
                header("Location: home.php"); exit;
            break;
            }

}









