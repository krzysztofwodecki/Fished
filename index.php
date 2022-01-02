<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('index', 'DefaultController');
Routing::get('mainpage', 'DefaultController');
Routing::get('profile', 'DefaultController');
Routing::get('competition', 'DefaultController');
Routing::get('results', 'DefaultController');   
Routing::get('attendee_list', 'DefaultController');
Routing::get('competition_photos', 'DefaultController');
Routing::run($path);

 