<?php

require "vendor/autoload.php";
$query = require "core/bootstrap.php";

use \Petomatic\Core\Request;

\Petomatic\Core\Router::load("routes.php")->direct(Request::prepare(), Request::method());