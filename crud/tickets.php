<?php
include($_SERVER['DOCUMENT_ROOT'] . '/SQL/connect_to_weatherApp.php');
global $pdo;
if(isset($_GET['tickets'])){
    $bookingId = ($_GET['tickets']);
}
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

        <button><a href="../crud/index.php">Home</a></button>
    </header>
    <main class="app">
        <div>
            <h3><?php global $bookingId;
                echo getClientInfo($bookingId)?></h3>
        </div>
        <div id="bookings">
            <table>
                <tr>
                    <th>Ticket</th>
                    <th>Price</th>
                    <th>Delete</th>
                </tr>

                <?php
                global $bookingId;
                displayTickets($bookingId)
                ?>
            </table>
        </div>

    </main>
    </body>
    </html>

<?php

function getClientInfo($bookingId)
{
    global $pdo;


        $query = "SELECT firstName, lastName FROM colyseum.clients 
                           where id=(SELECT clientId from colyseum.bookings where id=$bookingId )";
        $res = $pdo->query($query);

        if($res->rowCount()===1){
            $row = $res->fetch();
             echo 'Tickets for the client : '.$row['lastName'].' '.$row['firstName'];
        }
    }



function displayTickets($bookingId){
    global $pdo;
    $query =
        "SELECT * from colyseum.tickets 
                 where bookingsId = $bookingId ";

    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        $ticket = $row["id"];
        $price = $row["price"];

        $delete = '<form method="POST">
                      <button value="' . $ticket . '" type="submit" name="delete" class="delete">X</button>
                  </form>';

        echo '
            <tr>
                <td>' . $ticket . '</td>
                <td>' . $price . '</td>
                <td>' . $delete . '</td>              
            </tr>
            ';
    }

}


function listenDelete()
{
    global $bookingId;
    if (isset($_POST["delete"])) {

            $ticketId = $_POST["delete"];
            echo deleteTicket($ticketId);
            $url="tickets.php?tickets=".$bookingId;
        header("location: $url");
    }
}

function deleteTicket($ticketId)
{
    global $pdo;

    $deleteTicket = "DELETE FROM colyseum.tickets WHERE id=$ticketId";
    $resTicket = $pdo->exec($deleteTicket);

    return ($resTicket === 1) ? '<p> data correctly deleted </p>' : '<p> Error has occurred, data not deleted.</p>';
}




