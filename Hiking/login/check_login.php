<?php
include ($_SERVER['DOCUMENT_ROOT'].'/SQL/connect_to_weatherApp.php');
global $pdo;
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['password'])){
    echo "Vous êtes déjà connecté";
    echo '<button><a href="../index.php">home</a></button>';
    echo '<button><a href="logout.php">LogOut</a></button>';
}

else if(isset($_POST['username']) && isset($_POST['password'])) {

    $login = $_POST['username'];
    $pwd = $_POST['password'];

    if(isValidCredentials($login,$pwd) ){

        $_SESSION['username'] = $login;
        $_SESSION['password'] = $pwd;
        echo "you're connected";
        header ('location: ../index.php');
    }
    else {
        echo '<body onLoad="alert(\'Membre non reconnu...\')">';
        echo '<button><a href="./login.php">Login</a></button>';
    }
}
else {
    echo "Veuillez entrer votre nom d'utilisateur et votre mot de passe";
    echo '<button><a href="./login.php">Login</a></button>';


}

function IsValidCredentials($login,$pwd){
    global $pdo;
    $query = "SELECT password FROM becode.Users WHERE username = '$login'";
    $res = $pdo->query($query);

    if($res->rowCount()===1){
        if($row = $res->fetch())
            return $row['password'] === sha1($pwd);
    }


}