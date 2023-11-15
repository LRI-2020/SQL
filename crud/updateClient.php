<?php
include($_SERVER['DOCUMENT_ROOT'] . '/SQL/connect_to_weatherApp.php');
global $pdo;
if (isset($_GET["update"])){
    $id=$_GET["update"];
    getClient($id);
    listenForUpdate();
}

function getClient($id){
    global $pdo;
    $query = "SELECT firstName, lastName, birthDate FROM colyseum.clients WHERE id=$id";
    $res = $pdo->query($query);

    if($res->rowCount()===1){
        $row = $res->fetch();
        $birth = date('Y-m-d',strtotime($row['birthDate'])) ;
        echo '
                <button><a href="../crud/index.php">Home</a></button>
        <form id="updateClient" action="" method="post">
            <div>
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" value="'.$row['firstName'].'">
            </div>
            <div>
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" value="'.$row['lastName'].'">
            </div>
            <div>
                <label for="birth">Birth Date</label>
                <input type="date" name="birth" value="'.$birth.'">
            </div>
            <button type="submit" name="button">Send</button>
        </form>

        ';
    }
}

function listenForUpdate(){
    if (isset($_GET["update"]) && isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["birth"])) {
        $id = $_GET["update"];
        $lastName = $_POST["lastname"];
        $firstName = $_POST["firstname"];
        $birthDate = strtotime($_POST["birth"]);
       echo updateClient($id,$lastName,$firstName,$birthDate);
    }

}

function updateClient($id,$lastName,$firstName,$birthDate){
    $birth = date('Y-m-d', $birthDate);
    global $pdo;
    $update =
        "UPDATE colyseum.clients
        SET lastName = ?, firstName = ?, birthDate = ?
        WHERE id = ?";

    $res= $pdo->prepare($update)->execute([$lastName,$firstName,$birth,$id]);
    return ($res === true) ? '<p> Data correctly updated </p>' : '<p> Error has occurred, data not saved.</p>';
}