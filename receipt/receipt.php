<?php

declare(strict_types=1);
session_start();




$content = [

    'Island' => 'The Narrow Haven',
    'Hotel' => 'The Narrow Haven Resort',
    'Arrival_date' => $_SESSION['arrival'],
    'Departure_date' => $_SESSION['departure'],
    'Total-cost' => $_SESSION['totalCost'],
    'Stars' => '1',
    'Features' => '',
    'Additional_info' => 'Thank you for booking at The Narrow Haven! We hope you enjoy your stay!'
];

$receipt = json_encode($content);

header('content-type: application/json');
echo $receipt;
