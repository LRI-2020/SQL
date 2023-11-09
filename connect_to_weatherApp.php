<?php
include'pwd.php';

$pdo =connectToWeatherApp();
function connectToWeatherApp(){
    global $username;
    global $password;
    try {
        // On se connecte à MySQL
        $pdo= new PDO('mysql:host=localhost;dbname=weatherapp;charset=utf8', $username, $password);
    } catch (Exception $e) {
        // En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : ' . $e->getMessage());
    }
    return $pdo;
}
?>

