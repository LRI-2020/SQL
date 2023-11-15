<?php
include($_SERVER['DOCUMENT_ROOT'] . '/SQL/connect_to_weatherApp.php');
global $pdo;
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Crud</title>
    </head>
    <body>
    <main class="app">
        <div id="clients">
            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Birth date</th>
                    <th>Card</th>
                    <th>Card Number</th>
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







