<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Store.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        function test_allGetters()
        {
            $store_name = "Payless";
            $street = "392 SW Washington St.";
            $city = "Oregon City";
            $state = "OR";
            $id = 3;
            $test_store = new Store($store_name, $street, $city, $state, $id);

            $result1 = $test_store->getStoreName();
            $result2 = $test_store->getStreet();
            $result3 = $test_store->getCity();
            $result4 = $test_store->getState();
            $result5 = $test_store->getId();

            $this->assertEquals($store_name, $result1);
            $this->assertEquals($street, $result2);
            $this->assertEquals($city, $result3);
            $this->assertEquals($state, $result4);
            $this->assertEquals($id, is_numeric($result5));
        }

        function test_save()
        {
            $store_name = "Payless";
            $street = "392 SW Washington St.";
            $city = "Oregon City";
            $state = "OR";
            $test_store = new Store($store_name, $street, $city, $state, null);


            $test_store->save();
            $result = Store::getAll();

            $this->assertEquals([$test_store], $result);
        }

        function test_getAll()
        {
            $store_name = "Payless";
            $street = "392 SW Washington St.";
            $city = "Oregon City";
            $state = "OR";
            $test_store = new Store($store_name, $street, $city, $state, null);
            $test_store->save();

            $store_name = "Macy's";
            $street = "180 SW Washington St.";
            $city = "Clackamas";
            $state = "OR";
            $test_store2 = new Store($store_name, $street, $city, $state, null);
            $test_store2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store, $test_store2], $result);
        }
    }






 ?>
