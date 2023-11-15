<?php
include($_SERVER['DOCUMENT_ROOT'] . '/SQL/connect_to_weatherApp.php');
global $pdo;
listenUpdate();
listenDelete();
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Crud</title>
    </head>
    <body>
    <header>
        <button><a href="../crud/createClient.php">Create a new Client</a></button>
        <button><a href="../crud/createSpectacle.php">Create a new Show</a></button>
    </header>
    <main class="app">
        <div id="clients">
            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birth date</th>
                    <th>Card</th>
                    <th>Card Number</th>
                    <th>Bookings</th>
                    <th>Tickets</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>

                <?php
                displayClient();
                ?>
            </table>
        </div>

        <div>
            <table id="shows">
                <tr>
                    <th>Spectacles</th>
                </tr>

                <?php
                displayShowTypes();
                ?>
            </table>
        </div>

        <div id="Topclients">
            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birth date</th>
                    <th>Card</th>
                    <th>Card Number</th>
                    <th>Bookings</th>
                    <th>Tickets</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>

                <?php
                displayClient(20);
                ?>
            </table>
        </div>

        <div id="ClientsWith card">
            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birth date</th>
                    <th>Card</th>
                    <th>Card Number</th>
                </tr>

                <?php
                displayClientWithCard();
                ?>
            </table>
        </div>

        <div id="ClientsWithM">
            <h4>Clients by M</h4>
            <ul>
                <?php
                displayMClient();
                ?>
            </ul>

        </div>

        <div id="Spectacles">
            <h4>Shows</h4>
            <ul>
                <?php
                displayShows();
                ?>
            </ul>

        </div>


    </main>
    </body>
    </html>

<?php

function displayClient($count = null)
{
    global $pdo;
    $query = "SELECT * FROM colyseum.clients";
    if (isset($count)) {
        $query = "SELECT * FROM colyseum.clients LIMIT $count";
    }
    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        $id=$row["id"];
        $firstname = $row["firstName"];
        $lastName = $row["lastName"];
        $birdthDate = $row["birthDate"];
        $card = $row["card"];
        $cardNumber = $row["cardNumber"];
        $bookings = '<form action="bookings.php" method="POST">
                      <button value="' . $id . '" type="submit" name="bookings" class="bookings">Bookings</button>
                  </form>';
        $tickets = '<form action="tickets.php" method="POST">
                      <button value="' . $id . '" type="submit" name="tickets" class="tickets">Tickets</button>
                  </form>';
        $delete = '<form method="POST">
                      <button value="' . $id . '" type="submit" name="delete" class="delete">X</button>
                  </form>';
        $update = '<form method="POST">
                      <button value="' . $id . '" type="submit" name="update" class="delete"> update </button>
                  </form>';
        echo '
            <tr>
                <td>' . $firstname . '</td>
                <td>' . $lastName . '</td>
                <td>' . $birdthDate . '</td>
                <td>' . $card . '</td>
                <td>' . $cardNumber . '</td>
                <td>' . $bookings . '</td>
                <td>' . $tickets . '</td>
                <td>' . $update . '</td>
                <td>' . $delete . '</td>
            </tr>
            ';
    }

}

function displayClientWithCard()
{
    global $pdo;
    $query = "SELECT * FROM colyseum.clients WHERE card = 1";

    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        $firstname = $row["firstName"];
        $lastName = $row["lastName"];
        $birdthDate = $row["birthDate"];
        $card = $row["card"];
        $cardNumber = $row["cardNumber"];
        echo '
            <tr>
                <td>' . $firstname . '</td>
                <td>' . $lastName . '</td>
                <td>' . $birdthDate . '</td>
                <td>' . $card . '</td>
                <td>' . $cardNumber . '</td>
            </tr>
            ';
    }

}

function displayMClient()
{
    global $pdo;
    $query = "SELECT firstName, lastName FROM colyseum.clients WHERE lastName like 'M%' ORDER BY lastName asc";

    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        $firstname = $row["firstName"];
        $lastName = $row["lastName"];

        echo '
                <li>
                 <p>first name : ' . $firstname . '</p>
                            <p>last name : ' . $lastName . '</p>
                </li>
           
               
            ';
    }

}
function displayShows()
{
    global $pdo;
    $query = "SELECT title,performer,date,startTime FROM colyseum.shows order by title asc";

    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        $show = $row["title"];
        $performer = $row["performer"];
        $date = $row["date"];
        $time = $row["startTime"];

        echo '
                <li>
                   <p>' .$show. ' par '.$performer.' le '.$date.' à '.$time.'</p>
                </li>
           
               
            ';
    }

}

function displayShowTypes()
{
    global $pdo;
    $query = "SELECT type FROM colyseum.showTypes";
    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        echo '
            <tr>
                <td>' . $row["type"] . '</td>
            </tr>
            ';
    }

}

function listenUpdate(){

    if (isset($_POST["update"])) {
        $id = $_POST["update"];

        header("Location: updateClient.php?update=$id");

    }

}

function listenDelete()
{
    if (isset($_POST["delete"])) {

            $clientId = $_POST["delete"];
            echo deleteData($clientId);
    }
}

function deleteData($clientId)
{
    global $pdo;
    $delete = "DELETE FROM colyseum.clients WHERE id=$clientId";
    $res = $pdo->exec($delete);
    return ($res === 1) ? '<p> data correctly deleted </p>' : '<p> Error has occurred, data not deleted.</p>';
}




