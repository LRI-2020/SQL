<?php
include($_SERVER['DOCUMENT_ROOT'] . '/SQL/connect_to_weatherApp.php');
global $pdo;
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
            <h3><?php echo getClientInfo()?></h3>
        </div>
        <div id="bookings">
            <table>
                <tr>
                    <th>Booking</th>
                    <th>Number of tickets</th>
                    <th>Total Price</th>
                    <th>Delete</th>
                </tr>

                <?php
                displayBookings()
                ?>
            </table>
        </div>

    </main>
    </body>
    </html>

<?php

function getClientInfo()
{
    global $pdo;

    if(isset($_POST['bookings'])){
        $clientId = $_POST['bookings'];
        $query = "SELECT firstName, lastName FROM colyseum.clients where id=$clientId";
        $res = $pdo->query($query);

        if($res->rowCount()===1){
            $row = $res->fetch();
             echo 'Booking for the client : '.$row['lastName'].' '.$row['firstName'];
        }
    }
}

function displayBookings(){
    global $pdo;
    $clientId = $_POST['bookings'];
    $query =
        "SELECT count(id) as numberOfTickets, 
       SUM(price) as TotalPrice, 
       bookingsId from colyseum.tickets 
                 where bookingsId in 
                       (select id from colyseum.bookings where clientId = $clientId
                                                         ) group by bookingsId;
 ";

    $res = $pdo->query($query);

    while ($row = $res->fetch()) {
        $booking = $row["bookingsId"];
        $price = $row["price"];
        $ticketCount = $row["numberOfTickets"];
        $delete = '<form method="POST">
                      <button value="' . $booking . '" type="submit" name="delete" class="delete">X</button>
                  </form>';

        echo '
            <tr>
                <td>' . $booking . '</td>
                <td>' . $ticketCount . '</td>
                <td>' . $price . '</td>
                <td>' . $delete . '</td>              
            </tr>
            ';
    }

}


function listenDelete()
{
    if (isset($_POST["delete"])) {

            $bookingId = $_POST["delete"];
            echo deleteBooking($bookingId);
    }
}

function deleteBooking($bookingId)
{
    global $pdo;

    $deleteTickets = "DELETE FROM colyseum.tickets WHERE bookingsId=$bookingId";
    $resTicket = $pdo->exec($deleteTickets);
    $resBooking = 0;

    if($resTicket=== 1){
        $deleteBooking = "DELETE FROM colyseum.bookings WHERE id=$bookingId";
        $resBooking = $pdo->exec($deleteBooking);
    }
    return ($resBooking === 1 && $resTicket === 1) ? '<p> data correctly deleted </p>' : '<p> Error has occurred, data not deleted.</p>';
}




