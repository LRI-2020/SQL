<?php
include ($_SERVER['DOCUMENT_ROOT'].'/SQL/connect_to_weatherApp.php');
global $pdo;
listenUpdate();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ajouter une randonnée</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
</head>
<body>
<a href="/SQL/Hiking/index.php">Liste des données</a>
<h1>Ajouter</h1>
<form action="" method="post">
        <label for="name">Name</label>
        <input type="text" name="name" value="test">
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
        <input type="duration" name="duration" value="">
    </div>
    <div>
        <label for="height_difference">Dénivelé</label>
        <input type="text" name="height_difference" value="">
    </div>

    <div>
        <label for="available">Available</label>
        <select name="available">
            <option value="accessible">Accessible</option>
            <option value="difficilement accessible">Difficilement accessible</option>
            <option value="not accessible">Not Accessible</option>
        </select>
    </div>
    <button type="submit" name="button">Envoyer</button>
</form>
</body>
</html>

<?php
function listenUpdate(){
    echo true;
    if (isset($_GET["update"]) && isset($_POST["name"]) && isset($_POST["difficulty"]) && isset($_POST["distance"]) && isset($_POST["duration"]) && isset($_POST["height_difference"]) && isset($_POST["available"])) {
       echo "form is ok";
        $id = $_GET["update"];
        $name = $_POST["name"];
        $difficulty = $_POST["difficulty"];
        $distance = $_POST["distance"];
        $duration = $_POST["duration"];
        $height_difference = $_POST["height_difference"];
        $available = $_POST["available"];
        echo updateData($id,$name, $difficulty,$distance,$duration,$height_difference, $available);
    }

}

function updateData($id,$name,$difficulty,$distance,$duration,$height_difference, $available)
{
    global $pdo;
    $update =
        "UPDATE becode.hiking
        SET name = ?, difficulty = ?, distance = ?,duration=?,height_difference = ?, available=?
        WHERE id = ?";

    $res= $pdo->prepare($update)->execute([$name,$difficulty,$distance,$duration,$height_difference,$available,$id]);
    return ($res === true) ? '<p> Data correctly updated </p>' : '<p> Error has occurred, data not saved.</p>';
}
