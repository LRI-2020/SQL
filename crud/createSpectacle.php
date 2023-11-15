<?php
include($_SERVER['DOCUMENT_ROOT'] . '/SQL/connect_to_weatherApp.php');
global $pdo;
listenForAdd();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Crud</title>
    </head>
    <body>
    <main class="app">
        <button><a href="../crud/index.php">Home</a></button>

        <form id='client' action="" method="post">
            <div>
                <label for="title">Title</label>
                <input type="text" name="title" value="">
            </div>
            <div>
                <label for="performer">Performer</label>
                <input type="text" name="performer" value="">
            </div>
            <div>
                <label for="date">Date</label>
                <input type="date" name="date" value="">
            </div>
             <div>
                <label for="showType">Show Type</label>
                <input type="radio" name="showType" value=1> Concert<input>
                <input type="radio" name="showType" value=2> Théâtre<input>
                <input type="radio" name="showType" value=3> Humour <input>
                <input type="radio" name="showType" value=4> Danse <input>
            </div>
            <div>
                <label>Select 2 style</label>
                <select name="genre1" id="genre">
                    <?php
                    displayGenre();
                    ?>
                </select>
                <select name="genre2" id="genre">
                    <?php
                    displayGenre();
                    ?>
                </select>
            </div>
            <div>
                <label for="duration">Duration</label>
                <input type="time" name="duration" value="">
            </div>
            <div>
                <label for="startTime">start Time (hh:mm)</label>
                <input type="time" name="startTime" value="">
            </div>

            <button type="submit" name="button">Send</button>
        </form>

    </main>
    </body>
    </html>

<?php

function listenForAdd(): void
{

    if (isset($_POST["title"]) && isset($_POST["performer"])
        && isset($_POST["date"])
        && isset($_POST["genre1"])
        && isset($_POST["genre2"])
        && isset($_POST["duration"])
        && isset($_POST["startTime"])
        && isset($_POST["showType"])) {

        $title = $_POST["title"];
        $performer = $_POST["performer"];
        $date = strtotime($_POST["date"]);
        $duration = strtotime($_POST["duration"]);
        $startTime = strtotime($_POST["startTime"]);
        $genre1 = $_POST["genre1"];
        $genre2 = $_POST["genre2"];
        $showType = $_POST["showType"];
        echo createShow($title, $performer, $date,$duration,$startTime,$genre1,$genre2,$showType );
    }
}

function createShow($title, $performer, $date,$duration,$startTime,$genre1,$genre2,$showType): string
{
    $date = date('Y-m-d', $date);
    $durationSql = date('H:i:s', $duration);
    $time = date('H:i:s',$startTime);
    global $pdo;
    $insertShow =
    "INSERT INTO colyseum.shows
    (title, performer,date,duration,startTime,firstGenresId,secondGenreId,showTypesId)
    VALUES('$title','$performer','$date','$durationSql','$time',$genre1,$genre2,$showType)";
    $res = $pdo->exec($insertShow);

    return ($res === 1) ? '<p> Data correctly save </p>' : '<p> Error has occurred, data not saved.</p>';

}


function displayGenre(){
    global $pdo;
    $query = "SELECT * FROM colyseum.genres";

    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        $id = $row["id"];
        $genre = $row["genre"];

        echo '<option value="'.$id.'">'.$genre.'</option>';
    }
}








