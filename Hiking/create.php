<?php
include ($_SERVER['DOCUMENT_ROOT'].'/SQL/connect_to_weatherApp.php');
global $pdo;
listenAdd();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajouter une randonnée</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
<a href="/php-pdo/read.php">Liste des données</a>
<h1>Ajouter</h1>
<form action="" method="post">
    <div>
        <label for="name">Name</label>
        <input type="text" name="name" value="">
    </div>

    <div>
        <label for="difficulty">Difficulté</label>
        <select name="difficulty">
            <option value="très facile">Très facile</option>
            <option value="facile">Facile</option>
            <option value="moyen">Moyen</option>
            <option value="difficile">Difficile</option>
            <option value="très difficile">Très difficile</option>
        </select>
    </div>

    <div>
        <label for="distance">Distance</label>
        <input type="text" name="distance" value="">
    </div>
    <div>
        <label for="duration">Durée</label>
        <input type="time" name="duration" value="">
    </div>
    <div>
        <label for="height_difference">Dénivelé</label>
        <input type="text" name="height_difference" value="">
    </div>
    <button type="submit" name="button">Envoyer</button>
</form>
</body>
</html>

<?php
function listenAdd()
{
    if (isset($_POST["name"]) && isset($_POST["difficulty"]) && isset($_POST["distance"]) && isset($_POST["duration"]) && isset($_POST["height_difference"])) {
        $name = $_POST["name"];
        $difficulty = $_POST["difficulty"];
        $distance = $_POST["distance"];
        $duration = $_POST["duration"];
        $height_difference = $_POST["height_difference"];
        echo StoreData($name, $difficulty,$distance,$duration,$height_difference);
    }
}

function StoreData($name, $difficulty,$distance,$duration,$height_difference)
{
    global $pdo;
    $insert = "INSERT INTO becode.hiking (name,difficulty,distance,duration,height_difference) VALUES('$name','$difficulty',$distance,'$duration',$height_difference)";
    $res = $pdo->exec($insert);
    return ($res === 1) ? '<p> Data correctly save </p>' : '<p> Error has occurred, data not saved.</p>';
}
