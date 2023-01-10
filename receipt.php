<?php

declare(strict_types=1);
/* require __DIR__ . 'hotelFunctions.php'; */
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

    /* $path = '/logbook.json';

    file_put_contents(__DIR__ . $path, json_encode($content), FILE_APPEND); */
