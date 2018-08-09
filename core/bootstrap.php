<?php

session_start();
use Petomatic\Core\Application;
use Petomatic\Database\Connection;
use Petomatic\Database\QueryBuilder;

require 'core/functions.php';

Application::put('config', $config = require "config.php" );

Application::put('database', new QueryBuilder(
    Connection::make($config['database'])
));