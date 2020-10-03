<?php

use WireWorld\WireWorld;

require 'vendor/autoload.php';

$args = array_slice($argv, 1);

$wireWorld = new WireWorld();
$wireWorld->main($args);
