<?php

require "dbData.php";

$logbookData = json_decode(file_get_contents(__DIR__ . '/logbook.json'), true);


// foreach ($logbookData['vacation'] as $stay) {
//     echo $stay['island'];
// }


?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/summary.css">
    <title>Document</title>
</head>

<body>
    <header>
        <h1>
            Christmas-Pelago
        </h1>
    </header>
    <h2>Summary of all the bookings in logbook: </h1>
        <?php foreach ($logbookData['vacation'] as $stay) : ?>
            <div class="card-container">
                <div class="text-container">
                    <h3>Hotel: <?= $stay['hotel'] ?></h3>
                    <h4>Island: <?= $stay['island'] ?></h4>
                    <ul>
                        <li>Stars: <?= $stay['stars'] ?></li>
                        <li>Arrival date: <?= $stay['arrival_date'] ?></li>
                        <li>Departure date: <?= $stay['departure_date'] ?></li>
                        <li>
                            Features:
                            <?php foreach ($stay['features'] as $feature) : ?>
                                <?= $feature['name'] . " "; ?>
                            <?php endforeach ?>
                        </li>
                        <li>Total cost: <?= $stay['total_cost'] . "$"; ?></li>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
        <h2>Hotel statistics, January 2023:</h2>
        <div class="card-container">
            <div class="text-container">
                <ul>
                    <li>Total revenue: <?= $totalRevenue ?></li>
                    <li>Total amount of bookings: <?= $amountOfBookings ?></li>
                    <li>Avarage revenue per booking: <?= $avarageRev ?></li>
                </ul>
            </div>
        </div>


</body>

</html>