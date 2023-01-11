<?php
require 'vendor/autoload.php';
require 'functions.php';
require 'hotelFunctions.php';

session_start();

use benhall14\phpCalendar\Calendar as Calendar;

$db = new PDO('sqlite:pelago.db');

if (isset($_POST['first-name'], $_POST['last-name'], $_POST['email'], $_POST['submit'])) {
    $firstName = trim(htmlspecialchars($_POST['first-name']));
    $lastName = trim(htmlspecialchars($_POST['last-name']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    /* $options = implode(',', $_POST['options']); */
    $arrival = trim(htmlspecialchars($_POST['arrival-date']));
    $departure = trim(htmlspecialchars($_POST['departure-date']));
    $totalCost = (int)$_POST['calculated-cost'];
    $transferCode = $_POST['transfer-code'];


    $_SESSION['arrival'] = $arrival;
    $_SESSION['departure'] = $departure;
    $_SESSION['totalCost'] = $totalCost;


    if (checkTransferCode($transferCode, $totalCost)) {

        if (preventDoubleBooking($arrival, $departure)) {


            if (!empty($_POST['room-options'])) {
                $selected = $_POST['room-options'];


                $query = 'INSERT INTO Visitors (first_name, last_name, room_type, mail, arrival_date, departure_date, total_price) VALUES (:first_name, :last_name, :room_type, :mail, :arrival_date, :departure_date, :total_price)';

                $statement = $db->prepare($query);

                $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
                $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
                $statement->bindParam(':mail', $email, PDO::PARAM_STR);
                $statement->bindParam(':room_type', $selected, PDO::PARAM_STR);
                $statement->bindParam(':arrival_date', $arrival, PDO::PARAM_STR);
                $statement->bindParam(':departure_date', $departure, PDO::PARAM_STR);
                $statement->bindParam(':total_price', $totalCost, PDO::PARAM_INT);

                $statement->execute();
            }
            header('Location: /receipt/receipt.php/');
        };
    };


    addFunds($transferCode);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="stylesheet" type="text/css" href="styles/calendar.css">
    <script src="scripts/scripts.js" defer></script>
    <title>Christmas Pelago</title>
</head>

<body>

    <div class="body-wrapper">

        <header>
            <nav></nav>
            <h1>
                Christmas-Pelago
            </h1>
        </header>

        <section class="hotel-info-section">
            <h2>
                About hotel
            </h2>
            <p>
                Welcome to our lovely Hotel!. We are a small family run hotel that focuses on the island experience more that the price of our facility.
                We realized quickly that people are more interested in all the amazing experiences there are on these islands, more than that of a fancy hotel.
                Therefore we created a cheap hotel that allows you to spend you hard earn money on different adventures, whilst still giving you a
                reasonable place to call home. We hope you thoroughly enjoy your stay with us, and get the island vacation of your dream!
            </p>
        </section>

        <section class="picture-section">
            <div class="grid-container">
                <div class="grid-item budget">
                    <p>
                        Budget 5$
                    </p>
                </div>
                <div class="grid-item standard">
                    <p>
                        Standard 10$
                    </p>
                </div>
                <div class="grid-item luxury">
                    <p>
                        Luxury 15$
                    </p>
                </div>
            </div>
        </section>

        <section class="budget-section">
            <h2>budget Room</h2>
            <?php
            showBookings('budget');
            ?>
        </section>

        <section class="standard-section">
            <h2>Standard Room</h2>
            <?php
            showBookings('standard');
            ?>
        </section>

        <section class="luxury-section">
            <h2>Luxury Room</h2>
            <?php
            showBookings('luxury');
            ?>


        </section>

        <section class="option-selection">
            <div class="form-container">
                <form action="/index.php" method="post">
                    <div class="form-wrapper">
                        <label for="first-name">first-name</label>
                        <input type="text" name="first-name" placeholder="John Doe">
                        <label for="last-name">last-name</label>
                        <input type="text" name="last-name" placeholder="John Doe">
                        <label for="email">email</label>
                        <input type="email" name="email" required>
                        <div class="select-box">
                            <select name="room-options" id="room-options">
                                <option disabled selected value>Select a room!</option>
                                <option value="budget">budget</option>
                                <option value="standard">standard</option>
                                <option value="luxury">luxury</option>
                            </select>
                        </div>
                    </div>
                    <input type="date" name="arrival-date" id="arrival_date" min="2023-01-01" max="2023-01-31">
                    <input type="date" name="departure-date" id="departure_date" min="2023-01-01" max="2023-01-31">

                    <div id="transfer-code-container">
                        <input type="text" name="transfer-code" placeholder="transfer code">
                    </div>

                    <div id="amount">
                        <label for="total-amount">Total Amount</label>
                        <input name="calculated-cost" id="total-amount" type="text" readonly>
                    </div>
                    <button type="submit" name="submit">Choose options</button>
                </form>
            </div>
        </section>

        <footer></footer>
    </div>
</body>


</html>
