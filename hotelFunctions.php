<?php

declare(strict_types=1);
/* require 'db.php'; */
require 'vendor/autoload.php';

use benhall14\phpCalendar\Calendar;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;

/* $transferCode = '4a0dbf4c-c585-4d75-a9cf-b991f6ff74cc'; */

/*
Here's something to start your career as a hotel manager.

One function to connect to the database you want (it will return a PDO object which you then can use.)
    For instance: $db = connect('hotel.db');
                  $db->prepare("SELECT * FROM bookings");

one function to create a guid,
and one function to control if a guid is valid.
*/

function connect(string $dbName): object
{
    $dbPath = __DIR__ . '/' . $dbName;
    $db = "sqlite:$dbPath";

    // Open the database file and catch the exception if it fails.
    try {
        $db = new PDO($db);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Failed to connect to the database";
        throw $e;
    }
    return $db;
}

function guidv4(string $data = null): string
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

function isValidUuid(string $uuid): bool
{
    if (!is_string($uuid) || (preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/', $uuid) !== 1)) {
        return false;
    }
    return true;
}

function checkTransferCode($transferCode, $totalCost)
{
    if (!isValidUuid($transferCode)) {
        echo "Not a valid Code!";
        return false;
    } else {

        if ($totalCost < $transferCode) {
            echo "Sorry to poor!";
            return false;
        } else {




            $client = new \GuzzleHttp\Client();
            $options = [
                'form_params' => [
                    'transferCode' => $transferCode,
                    'totalCost' => $totalCost
                ]
            ];

            try {
                $response = $client->post('https://www.yrgopelago.se/centralbank/transferCode', $options);
                $response = $response->getBody()->getContents();
                $response = json_decode($response, true);
            } catch (\Exception $e) {
                return "something went wrong!" . $e;
            }
            return true;
        }
    }
    return true;
};

function addFunds($transferCode)
{

    $client = new \GuzzleHttp\Client();
    $options = [
        'form_params' => [
            'user' => 'Robin',
            'transferCode' => $transferCode
        ]
    ];

    try {
        $response = $client->post('https://www.yrgopelago.se/centralbank/deposit', $options);
        $response = $response->getBody()->getContents();
        $response = json_decode($response, true);
        return true;
    } catch (\Exception $e) {
        return "money not transfered!" . $e;
    }
};


function showBookings($roomChoice)
{
    $db = new PDO('sqlite:pelago.db');

    $calendar = new Calendar;

    if ($roomChoice === "budget") {
        $response = $db->query('SELECT arrival_date, departure_date FROM Visitors WHERE room_type = "budget"');
        $response->execute();
        $result = $response->fetchAll();
        foreach ($result as $resp) {
            $arrivalDate = $resp['arrival_date'];
            $departureDate = $resp['departure_date'];
            $calendar->addEvent($arrivalDate, $departureDate, '', true);
        }
    } else if ($roomChoice === "standard") {
        $response = $db->query('SELECT arrival_date, departure_date FROM Visitors WHERE room_type = "standard"');
        $response->execute();
        $result = $response->fetchAll();
        foreach ($result as $resp) {
            $arrivalDate = $resp['arrival_date'];
            $departureDate = $resp['departure_date'];
            $calendar->addEvent($arrivalDate, $departureDate, '', true);
        }
    } else if ($roomChoice === "luxury") {
        $response = $db->query('SELECT arrival_date, departure_date FROM Visitors WHERE room_type = "luxury"');
        $response->execute();
        $result = $response->fetchAll();

        foreach ($result as $resp) {
            $arrivalDate = $resp['arrival_date'];
            $departureDate = $resp['departure_date'];
            $calendar->addEvent($arrivalDate, $departureDate, '', true);
        }
    }
    echo $calendar->display(date('Y-01-01'));
};




function preventDoubleBooking($arrival, $departure)
{
    $userArrivalDate = $arrival;
    $userDepartureDate = $departure;
    $roomOption = $_POST['room-options'];

    $db = new PDO('sqlite:pelago.db');



    $userPeriod = new DatePeriod(
        new DateTime($userArrivalDate),
        new DateInterval('P1D'),
        new DateTime($userDepartureDate)
    );

    $response = ('SELECT arrival_date, departure_date FROM Visitors WHERE room_type IS :room_type');
    $statement = $db->prepare($response);
    $statement->bindValue(':room_type', $roomOption);
    $statement->execute();
    $res = $statement->fetchAll();


    foreach ($res as $booking) {
        $bookedPeriod = new DatePeriod(
            new DateTime($booking['arrival_date']),
            new DateInterval('P1D'),
            new DateTime($booking['departure_date'])
        );

        foreach ($bookedPeriod as $key => $bookedDate) {
            foreach ($userPeriod as $key => $userDate) {
                if ($userDate == $bookedDate) {
                    echo "Room is already Booked, please try another date";
                    return false;
                }
            }
        }
    }
    return true;
}

// function jsonReceipt($arrival, $departure, $totalCost)
// {
//     $content = [

//         'Island' => 'The Narrow Haven',
//         'Hotel' => 'The Narrow Haven Resort',
//         'Arrival_date' => $arrival,
//         'Departure_date' => $departure,
//         'Total_cost' => $totalCost,
//         'Stars' => '1',
//         'Features' => '',
//         'Additional_info' => ''
//     ];


//     echo json_encode($content);

//     header('content-type: application/json');

//     /* $path = '/logbook.json';

//     file_put_contents(__DIR__ . $path, json_encode($content), FILE_APPEND); */
// };
