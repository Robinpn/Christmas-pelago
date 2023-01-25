<?php

$json = json_decode(file_get_contents(__DIR__ . '/logbook.json'), true);
header('content-type: application/json');
echo json_encode($json);
