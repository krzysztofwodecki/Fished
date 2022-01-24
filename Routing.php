<?php 

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/ProfilePhotosController.php';
require_once 'src/controllers/CompetitionPhotosController.php';
require_once 'src/controllers/UserController.php';
require_once 'src/controllers/CompetitionController.php';
require_once 'src/controllers/MapController.php';
require_once 'src/controllers/ScoreController.php';
require_once 'src/controllers/AttendanceController.php';

class Routing {
    public static $routes;

    public static function get($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function post($url, $view) {
        self::$routes[$url] = $view;
    }

    public static function run($url) {
        $action = explode("/", $url)[0];

        if(!array_key_exists($action, self::$routes)) {
            die("Wrong url!");
        }

        $controller = self::$routes[$action];
        $object = new $controller;
        $action = $action ?: 'index';

        $object->$action();
    }
}