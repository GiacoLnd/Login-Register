<?php
if(isset($_GET["action"])) {
    switch($_GET["action"]){
        case'register': 
            // Connexion à la DB
            $pdo = new PDO("mysql::host=localhost;dbname=forum_giacomo;charset=utf8", "root", "");
            // Filtrage des données entrées
            $pseudo= filter_input(INPUT_POST, "pseudo", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email= filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
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
            break;
            
            case 'login': 
    }
}










?>