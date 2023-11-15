<?php
include ($_SERVER['DOCUMENT_ROOT'].'/SQL/connect_to_weatherApp.php');
include ($_SERVER['DOCUMENT_ROOT'].'/SQL/Hiking/login/evaluateAccess.php');
global $pdo;
listen();

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>HIking</title>
    </head>
    <body>
    <main class="app">

        <button><a href="./login/login.php">Login</a></button>
        <button><a href="./login/logout.php">Logout</a></button>

        <table style="width:100%">
            <tr>
                <th>Name</th>
                <th>Difficulty</th>
                <th>distance</th>
                <th>duration</th>
                <th>height difference</th>
                <th>available</th>
                <th>Delete</th>
                <th>Update</th>
            </tr>

            <?php
            displayData($pdo);
            ?>

        </table>
    </main>
    </body>
    </html>

<?php

function displayData()
{
    global $pdo;
    $query = "SELECT * FROM becode.hiking";
    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        $id = $row['id'];
        $name = $row["name"];
        $difficulty = $row["difficulty"];
        $distance = $row["distance"];
        $duration = $row["duration"];
        $height_difference = $row["height_difference"];
        $available = $row["available"];
        $delete = '<form method="POST">
                      <button value="' . $id . '" type="submit" name="delete" class="delete">X     </button>
                  </form>';
        $update = '<form method="POST">
                      <button value="' . $id . '" type="submit" name="update" class="delete"> update </button>
                  </form>';
        echo '
            <tr>
                <td>' . $name . '</td>
                <td>' . $difficulty . '</td>
                <td>' . $distance . '</td>
                <td>' . $duration . '</td>
                <td>' . $height_difference . '</td>
                <td>' . $available . '</td>
                <td>' . $delete . '</td>
                <td>' . $update . '</td>
            </tr>
            ';
    }

}

function listen()
{
    listenDelete();
    listenUpdate();
}

function listenUpdate(){

    if (isset($_POST["update"])) {
        $id = $_POST["update"];

        if(canAccess()){
            header("Location: ./update.php?update=$id");
        }

        else{
            echo '<body onLoad="alert(\'You are not allowed to update a hike\')">';

        }

    }

}



function listenDelete()
{
    if (isset($_POST["delete"])) {
        if(canAccess()){
            $hike = $_POST["delete"];
            echo deleteData($hike);        }

        else{
            echo '<body onLoad="alert(\'You are not allowed to delete a hike\')">';

        }

    }
}


function deleteData($hike)
{
    global $pdo;
    $delete = "DELETE FROM becode.hiking WHERE id=$hike";
    $res = $pdo->exec($delete);
    return ($res === 1) ? '<p> data correctly deleted </p>' : '<p> Error has occurred, data not deleted.</p>';
}

