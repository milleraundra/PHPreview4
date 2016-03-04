<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Store.php";
    require_once __DIR__."/../src/Brand.php";

    $app = new Silex\Application();

    $server = 'mysql:host=localhost;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    // use Symfony\Component\HttpFoundation\Request;
    // Request::enableHttpMethodParameterOverride()
//Home Page
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });

//create store on index page
    $app->post("/create/store", function() use ($app) {
        $new_store = new Store($_POST['store_name'], $_POST['street'], $_POST['city'], $_POST['state']);
        $new_store->save();
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });
//create brand on index page
    $app->post("/create/brand", function() use ($app) {
        $new_brand = new Brand($_POST['brand_name']);
        $new_brand->save();
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });
//view store page
    $app->get("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $store_brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app['twig']->render('store.html.twig', array('store' => $store, 'match_brands' => $store_brands, 'all_brands' => $all_brands));
    });
//add a brand to a store
    $app->post("/store/{id}/add/brand", function($id) use ($app) {
        $store = Store::find($id);
        $brand_id = $_POST['brand'];
        $brand = Brand::find($brand_id);
        $store->addBrand($brand);
        $store_brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app['twig']->render('store.html.twig', array('store' => $store, 'match_brands' => $store_brands, 'all_brands' => $all_brands));
    });

//create brand on store page
    $app->post("/store/{id}/create/brand", function($id) use ($app) {
        $store = Store::find($id);
        $new_brand = new Brand($_POST['brand_name']);
        var_dump($new_brand);
        $new_brand->save();
        $store_brands = $store->getBrands();
        $all_brands = Brand::getAll();
        return $app['twig']->render('store.html.twig', array('store' => $store, 'match_brands' => $store_brands, 'all_brands' => $all_brands));
    });

//view brand page
    // $app->get("/brand/{id}")

    return $app;

 ?>
