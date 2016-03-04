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
            $street = "392 SW Washington St."
            $city = "Oregon City";
            $state = "OR";
            $test_store = new Store($store_name, $street, $city, $state, 3);

            $result1 = $test_store->getStoreName();
            $restul2 = $test_store->getStreet();
            $result3 = $test_store->getCity();
            $result4 = $test_store->getState();
            $result5 = $test_store->getId();

            $this->assertEquals($store_name, $result1);
            $this->assertEquals($street, $result2);
            $this->assertEquals($city, $result3);
            $this->assertEquals($state, $result4);
            $this->assertEquals($id, is_numeric($result5));
        }
    }






 ?>
