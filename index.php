<?php
require 'vendor/autoload.php';
require 'functions.php';
//the narrow haven



use benhall14\phpCalendar\Calendar as Calendar;
?>

<?php

$db = new PDO('sqlite:pelago.db');
$smt = $db->prepare('SELECT * FROM rooms');
$smt->execute();
$data = $smt->fetchAll();

if (isset($_POST['first-name'], $_POST['last-name'], $_POST['email'], $_POST['submit'] /* $_POST['breakfast'], $_POST['ocean-view'], $_POST['room-service'], $_POST['options'] */)) {
    $firstName = trim(htmlspecialchars($_POST['first-name']));
    $lastName = trim(htmlspecialchars($_POST['last-name']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $options = implode(',', $_POST['options']);
    $arrival = trim(htmlspecialchars($_POST['arrival-date']));
    $departure = trim(htmlspecialchars($_POST['departure-date']));
    $totalCost = $_POST['calculated-cost'];




    /*     foreach ($options as $option) {
        if ($option === $_POST['options']) {
            $option = 1;
            echo $option;
        } else {
            $options = 0;
            echo $option;
        } */


    foreach ($data as $price) {
        $amount = $price['price'];

        /* echo $amount; */
    }

    switch ($amount) {
        case 'budget':
            $amount = 5;
            break;
        case 'standard':
            $amount = 10;
            break;
        case 'luxury':
            $amount = 10;
            break;
    }

    echo $amount;

    if (!empty($_POST['room-options'])) {
        $selected = $_POST['room-options'];


        $query = 'INSERT INTO Visitors (first_name, last_name, room_type, mail, arrival_date, departure_date, room_add_ons, total_price) VALUES (:first_name, :last_name, :room_type, :mail, :arrival_date, :departure_date, :room_add_ons, :total_price)';

        $statement = $db->prepare($query);

        $statement->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $statement->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $statement->bindParam(':mail', $email, PDO::PARAM_STR);
        $statement->bindParam(':room_type', $selected, PDO::PARAM_STR);
        $statement->bindParam(':arrival_date', $arrival, PDO::PARAM_STR);
        $statement->bindParam(':departure_date', $departure, PDO::PARAM_STR);
        $statement->bindParam(':room_add_ons', $options, PDO::PARAM_STR);
        $statement->bindParam(':total_price', $totalCost, PDO::PARAM_STR);
        /*         $statement->bindParam(':ocean_view', $options, PDO::PARAM_STR);
        $statement->bindParam(':room_service', $options, PDO::PARAM_STR); */

        $statement->execute();

        /*         switch ($selected) {
            case 'Budget':
                $budget = 3;
                break;
            case 'Standard':
                $standard = 5;
                break;
            case 'Luxury':
                $luxury = 50;
                break;
        }

        switch ($options) {
            case 'breakfast':
                $breakfast = 5;
                break;
            case 'ocean-view':
                $oceanView = 10;
                break;
            case 'room-service':
                $roomService = 15;
                break;
        } */



        /* echo calcPrice($selected, $options); */
    }
}


/* if (isset($_POST['submit'])) {
    if (!empty($_POST['room-options'])) {
        $selected = $_POST['room-options'];
        echo 'you have chosen' . $selected;
    } else {
        echo 'something went wrong there buddy!';
    }
} */


/* $cost = $db->prepare('SELECT * FROM rooms');
$cost->execute();
$dbData = $cost->fetchAll();

foreach ($dbData as $roomPrice) {
    echo $roomPrice['room_choice'] . " " . $roomPrice['price'];
} */


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
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla laborum iste assumenda aspernatur ratione nihil eos explicabo saepe temporibus fugiat molestiae commodi, consequuntur numquam dolores praesentium architecto corrupti rem. Nulla?
                Doloremque inventore dolores pariatur cumque, porro exercitationem! Cumque harum praesentium animi optio veritatis aperiam temporibus soluta? Ullam possimus quasi eum in necessitatibus praesentium, est cupiditate modi voluptatem, vitae reprehenderit ipsa.
                Doloribus obcaecati voluptas necessitatibus modi, molestiae accusantium perferendis sed saepe in est accusamus nobis iusto iure, animi quibusdam assumenda unde blanditiis, nisi eveniet beatae culpa itaque! Deleniti modi officia sed?
            </p>
        </section>

        <section class="picture-section">
            <div class="grid-container">
                <div class="grid-item">
                    <p>
                        Budget 5$
                    </p>
                    <img src="" alt="">
                </div>
                <div class="grid-item">
                    <p>
                        Standard 10$
                    </p>
                    <img src="" alt="">
                </div>
                <div class="grid-item">
                    <p>
                        Luxury 15$
                    </p>
                    <img src="" alt="">
                </div>
            </div>
        </section>

        <section class="calendar-section">
            <?php
            $calendar = new calendar;
            $calendar->stylesheet();

            if (isset($_POST['submit'])) {
                $start = trim(htmlspecialchars($_POST['arrival-date']));
                $end = trim(htmlspecialchars($_POST['departure-date']));

                $events = array();
                $events[] = array(
                    'start' => "{$start}",
                    'end' => "{$end}",
                    'mask' => true
                );

                $calendar->addEvents($events);
            }

            echo $calendar->draw(date('Y-01-01'));

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


                                <!--                                 <option value="Budget">Budget</option>
                                <option value="Standard">Standard</option>
                                <option value="Luxury">luxury</option> -->
                            </select>
                        </div>
                    </div>
                    <input type="date" name="arrival-date" id="arrival_date" min="2023-01-01" max="2023-01-31">
                    <input type="date" name="departure-date" id="departure_date" min="2023-01-01" max="2023-01-31">

                    <div class="checkbox-container">
                        <div>
                            <input type="checkbox" name="options[]" value="breakfast">
                            <label for="breakfast">breakfast</label>
                        </div>

                        <div>
                            <input type="checkbox" name="options[]" value="ocean-view">
                            <label for="ocean-view">ocean-view</label>
                        </div>

                        <div>
                            <input type="checkbox" name="options[]" value="room-service">
                            <label for="room-service">room-service</label>
                        </div>
                    </div>

                    <div id="amount">
                        <label for="total-amount">Total Amount</label>
                        <input name="calculated-cost" id="total-amount" type="text" readonly>
                    </div>
                    <button type="submit" name="submit">Choose options</button>
                    <!--                     <input type="submit" name="submit" value="choose options"> -->
                </form>
            </div>
        </section>

        <footer></footer>
    </div>
</body>


</html>
