<?php

?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">

        <title>Crud</title>
    </head>
    <body>
    <main class="app">


    </main>
    </body>
    </html>

<?php

function listenForAdd(): void
{

    if (isset($_POST["firstname"]) && isset($_POST["lastname"])
        && isset($_POST["birth"])
        && isset($_POST["card"])) {

        if ($_POST["card"] === "true" && (!isset($_POST["cardnumber"]) || !isset($_POST['cardtype']))) {
            throw new Error('Card number must be defined');

        }
        $firstName = $_POST["firstname"];
        $lastName = $_POST["lastname"];
        $birth = strtotime($_POST["birth"]);
        $card = $_POST["card"];
        $cardType = $card ? $_POST["cardtype"] : null;
        $cardNumber = $card ? $_POST["cardnumber"] : null;
        echo createClient($firstName, $lastName, $birth, $card, $cardNumber, $cardType);
    }
}

function createClient($firstName, $lastName, $birth, $card, $cardNumber = null, $cardType = null): string
{
    $date = date('Y-m-d', $birth);
    $hasCard = $card === "true" ? 1 : 0;
    global $pdo;
    $insertClient = "INSERT INTO colyseum.clients (firstName, lastName,birthDate,card, cardNumber)
VALUES('$firstName','$lastName','$date',$hasCard,$cardNumber)";
    $res = $pdo->exec($insertClient);
    $cardRes = 1;
    if ($cardNumber && $cardType) {

        $cardRes = createCard($cardNumber, $cardType);

    }

    return ($res === 1 && $cardRes) ? '<p> Data correctly save </p>' : '<p> Error has occurred, data not saved.</p>';

}

function createCard($cardNumber, $cardType): bool
{
    global $pdo;

    $insertCard = "INSERT INTO colyseum.cards (cardNumber, cardTypesId)
VALUES($cardNumber,$cardType)";
    echo $insertCard;

    return 1;
    $res = $pdo->exec($insertCard);
   return ($res === 1);

}








