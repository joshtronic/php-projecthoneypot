<?php

require_once 'ProjectHoneyPot.php';

$php = new ProjectHoneyPot('YOUR_KEY');

// Simulate no record returned
var_dump($php->query('127.0.0.1'));

// Simulate different types
/*
var_dump($php->query('127.1.1.0'));
var_dump($php->query('127.1.1.1'));
var_dump($php->query('127.1.1.2'));
var_dump($php->query('127.1.1.3'));
var_dump($php->query('127.1.1.4'));
var_dump($php->query('127.1.1.5'));
var_dump($php->query('127.1.1.6'));
var_dump($php->query('127.1.1.7'));
*/

// Simulate different threat levels
/*
var_dump($php->query('127.1.10.1'));
var_dump($php->query('127.1.20.1'));
var_dump($php->query('127.1.40.1'));
var_dump($php->query('127.1.80.1'));
*/

// Simulate different number of days
/*
var_dump($php->query('127.10.1.1'));
var_dump($php->query('127.20.1.1'));
var_dump($php->query('127.40.1.1'));
var_dump($php->query('127.80.1.1'));
*/

// Not a simulation, legit comment spammer
var_dump($php->query('60.169.75.161'));

?>
