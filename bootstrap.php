<?php

session_start();

header('Content-Type: text/html; charset=utf-8');

require 'vendor/autoload.php';
require 'Examples/config.php';

\Tracy\Debugger::enable();