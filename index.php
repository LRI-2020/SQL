<?php
include 'connect_to_weatherApp.php';
global $pdo;
listen();

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>DPO</title>
    </head>
    <body>
    <main class="app">
        <table style="width:100%">
            <tr>
                <th>Ville</th>
                <th>Max</th>
                <th>Min</th>
                <th>Delete</th>
            </tr>

            <?php
            displayData($pdo);
            //            $query = "SELECT * FROM weatherapp.meteo";
            //            $res = $pdo->query($query);
            //            while ($row = $res->fetch()) {
            //                $ville = $row["ville"];
            //                $max = $row["haut"];
            //                $min = $row["bas"];
            //
            //                echo '
            //            <tr>
            //                <td>' . $ville . '</td>
            //                <td>' . $max . '</td>
            //                <td>' . $min . '</td>
            //            </tr>
            //            ';
            //
            //
            //            }
            ?>

        </table>

        <form method="post">
            <label for="ville">Ville</label>
            <input type="text" id="ville" name="ville">
            <label for="haut">Température Max</label>
            <input type="number" id="haut" name="haut">
            <label for="bas">Température Min</label>
            <input type="number" id="bas" name="bas">
            <button type="submit">Send</button>
        </form>
    </main>
    </body>
    </html>

<?php

function displayData()
{
    global $pdo;
    $query = "SELECT * FROM weatherapp.meteo";
    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        $ville = $row["ville"];
        $max = $row["haut"];
        $min = $row["bas"];
        $delete = '<form method="POST">
                      <button value="' . $ville . '" type="submit" name="delete" class="delete">X     </button>
                  </form>';
        echo '
            <tr>
                <td>' . $ville . '</td>
                <td>' . $max . '</td>
                <td>' . $min . '</td>
                <td>' . $min . '</td>
                <td>' . $delete . '</td>
            </tr>
            ';
    }

}

function listen()
{
    listenAdd();
    listenDelete();
}

function listenAdd()
{
    if (isset($_POST["ville"]) && isset($_POST["haut"]) && isset($_POST["bas"])) {
        $ville = $_POST["ville"];
        $haut = $_POST["haut"];
        $bas = $_POST["bas"];
        echo StoreData($ville, $haut, $bas);
    }
}

function listenDelete()
{
    if (isset($_POST["delete"])) {
        $ville = $_POST["delete"];
        echo deleteData($ville);
    }
}
function StoreData($ville, $haut, $bas)
{
    global $pdo;
    $insert = "INSERT INTO meteo (ville,haut,bas) VALUES('$ville',$haut,$bas)";
    $res = $pdo->exec($insert);
    return ($res === 1) ? '<p> Data correctly save </p>' : '<p> Error has occurred, data not saved.</p>';
}


function deleteData($ville)
{
    global $pdo;
    $delete = "DELETE FROM meteo WHERE ville='$ville'";
    $res = $pdo->exec($delete);
    return ($res === 1) ? '<p> '.$ville.' correctly delete </p>' : '<p> Error has occurred, '.$ville.' not deleted.</p>';
}

