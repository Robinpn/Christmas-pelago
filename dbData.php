<?php

declare(strict_types=1);

require 'hotelFunctions.php';


$db = connect('pelago.db');


$statement = $db->query('SELECT * FROM Visitors');

$visitors = $statement->fetchAll(PDO::FETCH_ASSOC);

//placing the total price of each booking in an array
$payments = array();
foreach ($visitors as $visitor) {
    $payments[] = $visitor['total_price'];
}

//calculating the total revenue of the hotel.
$totalRevenue = array_sum($payments);
//calculating the average revenue per booking. 
$avarageRev = $totalRevenue / count($payments);
//calculating amount of bookings.
$amountOfBookings = count($payments);

// echo "amnt of bookings: " . count($visitors);
