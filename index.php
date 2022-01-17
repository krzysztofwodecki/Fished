<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('', 'DefaultController');

Routing::get('logout', 'SecurityController');

Routing::get('registerPage', 'DefaultController');
Routing::post('register', 'SecurityController');

Routing::get('main_page', 'CompetitionController');
Routing::post('login', 'SecurityController');
Routing::get('getFisheries', 'MapController');

Routing::post('add_competition', 'CompetitionController');
Routing::post('add_fishery', 'MapController');

Routing::get('profile', 'ProfileController');
Routing::post('addPhotoOnProfile', 'PhotoController');
Routing::get('deletePhotoOnProfile', 'PhotoController');


Routing::get('competition', 'DefaultController');
Routing::get('results', 'DefaultController');   
Routing::get('attendee_list', 'DefaultController');
Routing::get('competition_photos', 'DefaultController');
Routing::get('photos_mobile', 'DefaultController');
Routing::get('map_mobile', 'DefaultController');
Routing::get('achievements_mobile', 'DefaultController');
Routing::get('news_mobile', 'DefaultController');


Routing::run($path);

