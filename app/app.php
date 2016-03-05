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
// delete all on index page
    $app->post("/delete_all", function() use ($app) {
        Brand::deleteAll();
        Brand::deleteAllJoin();
        Store::deleteAll();
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });
// view all_stores_brands page
    $app->get("/view_all", function() use ($app) {
        return $app['twig']->render('view_all.html.twig', array('all_stores' => Store::getAll()));
    });

//view store page
    $app->get("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $message = null;
        return $app['twig']->render('store.html.twig', array('store' => $store, 'all_stores' => Store::getAllExcept($id), 'match_brands' => $store->getBrands(), 'all_brands' => Brand::getAll(), 'message' => $message));
    });
//add a brand to a store
    $app->post("/store/{id}/add/brand", function($id) use ($app) {
        $store = Store::find($id);
        $brand = Brand::find($_POST['brand']);
        $already_saved = $store->addBrand($brand);
        $message = null;
        if ($already_saved != null) {
            $message = "That brand has already been added.";
        } else {
            $message = "You added a new brand.";
        }
        return $app['twig']->render('store.html.twig', array('store' => $store, 'all_stores' => Store::getAllExcept($id), 'match_brands' => $store->getBrands(), 'all_brands' => Brand::getAll(), 'message' => $message));
    });

//create brand on store page
    $app->post("/store/{id}/create/brand", function($id) use ($app) {
        $store = Store::find($id);
        $new_brand = new Brand($_POST['brand_name']);
        $new_brand->save();
        $message = null;
        return $app['twig']->render('store.html.twig', array('store' => $store, 'all_stores' => Store::getAllExcept($id), 'match_brands' => $store->getBrands(), 'all_brands' => Brand::getAll(), 'message' => $message));
    });

//delete individual store
    $app->post("/store/{id}/delete", function($id) use ($app) {
        $store = Store::find($id);
        $store->delete();
        return $app['twig']->render('index.html.twig', array('all_stores' => Store::getAll(), 'all_brands' => Brand::getAll()));
    });

//view brand page
    $app->get("/brand/{id}", function($id) use ($app) {
        $brand = Brand::find($id);
        $message = null;
        return $app['twig']->render('brand.html.twig', array('brand'=> $brand, 'all_brands' => Brand::getAllExcept($id), 'match_stores' => $brand->getStores(), 'all_stores' => Store::getAll(), 'message' => $message));
    });
// add store to a brand
    $app->post("/brand/{id}/add/store", function($id) use ($app) {
        $brand = Brand::find($id);
        $store = Store::find($_POST['store']);
        $already_saved = $brand->addStore($store);
        $message = null;
        if ($already_saved != null) {
            $message = "That store has already been added.";
        } else {
            $message = "You added a new store.";
        }
        return $app['twig']->render('brand.html.twig', array('brand'=> $brand, 'all_brands' => Brand::getAllExcept($id), 'match_stores' => $brand->getStores(), 'all_stores' => Store::getAll(), 'message' => $message));
    });
//create store on brand page
    $app->post("/brand/{id}/create/store", function($id) use ($app) {
        $new_store = new Store($_POST['store_name'], $_POST['street'], $_POST['city'], $_POST['state']);
        $new_store->save();
        $brand = Brand::find($id);
        $message = null;
        return $app['twig']->render('brand.html.twig', array('brand'=> $brand, 'all_brands' => Brand::getAllExcept($id), 'match_stores' => $brand->getStores(), 'all_stores' => Store::getAll(), 'message' => $message));
    });

    return $app;

 ?>
