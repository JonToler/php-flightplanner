<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Flight.php";
    require_once __DIR__."/../src/City.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=flight_planner';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    $app->get("/", function() use ($app) {
        return $app['twig']->render('home.html.twig', array('cities' => City::getAll(), 'flights' => Flight::getAll()));
    });

    $app->post("/add_city", function() use ($app) {
        $new_city_name = new City($_POST['city_name']);
        $new_city_name->save();
        return $app->redirect("/");
    });

    $app->post("/delete_all_cities", function() use ($app) {
        City::deleteAll();
        return $app->redirect("/");
    });

    return $app;
 ?>
