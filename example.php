<?php

require_once 'ProjectHoneyPot.php';

$php = new ProjectHoneyPot('YOUR_KEY');

/*
var_dump($php->query('127.0.0.1'));
var_dump($php->query('127.1.1.0'));
var_dump($php->query('127.1.1.1'));
var_dump($php->query('127.1.1.2'));
var_dump($php->query('127.1.1.3'));
var_dump($php->query('127.1.1.4'));
var_dump($php->query('127.1.1.5'));
var_dump($php->query('127.1.1.6'));
var_dump($php->query('127.1.1.7'));
*/
var_dump($php->query('60.169.75.161'));

?>
