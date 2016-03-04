<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    // use Symfony\Component\HttpFoundation\Request;
    // Request::enableHttpMethodParameterOverride()

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    return $app;

 ?>
