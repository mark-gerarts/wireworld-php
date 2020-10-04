<?php

use WireWorld\WireWorld;
use WireWorld\WireWorldCliMenu;

require 'vendor/autoload.php';

$args = $argv;
$args = array_slice($args, 1);
WireWorld::main($args);
