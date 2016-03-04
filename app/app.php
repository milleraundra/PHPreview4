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
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });

    $app->post("/create/store", function() use ($app) {
        $new_store = new Store($_POST['store_name'], $_POST['street'], $_POST['city'], $_POST['state']);
        $new_store->save();
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });

    return $app;

 ?>
