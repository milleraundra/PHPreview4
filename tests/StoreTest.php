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
        protected function TearDown()
        {
            Store::deleteAll();
        }

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

        function test_adjustPunctuation()
        {
            $store_name = "Macy's";
            $street = "180 SW Washington St.";
            $city = "Clackamas";
            $state = "OR";
            $test_store2 = new Store($store_name, $street, $city, $state, null);

            $test_store2->save();
            $result = $test_store2->getStoreName();

            $this->assertEquals("Macy\'s", $result);
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

            $store_name = "Dress Barn";
            $street = "180 SW Washington St.";
            $city = "Clackamas";
            $state = "OR";
            $test_store2 = new Store($store_name, $street, $city, $state, null);
            $test_store2->save();

            $result = Store::getAll();

            $this->assertEquals([$test_store, $test_store2], $result);
        }

        function test_deleteAll()
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

            Store::deleteAll();
            $result = Store::getAll();

            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $store_name = "Payless";
            $street = "392 SW Washington St.";
            $city = "Oregon City";
            $state = "OR";
            $test_store = new Store($store_name, $street, $city, $state, null);
            $test_store->save();

            $store_name = "Dress Barn";
            $street = "180 SW Washington St.";
            $city = "Clackamas";
            $state = "OR";
            $test_store2 = new Store($store_name, $street, $city, $state, null);
            $test_store2->save();

            $result = Store::find($test_store->getId());

            $this->assertEquals($test_store, $result);
        }

        function test_update()
        {
            $store_name = "Payless";
            $street = "392 SW Washington St.";
            $city = "Oregon City";
            $state = "OR";
            $test_store = new Store($store_name, $street, $city, $state, null);
            $test_store->save();

            $new_store_name = "Khols";
            $new_street = "924 NE Trump St.";
            $new_city = "Austin";
            $new_state = "TX";
            $test_store->update($new_store_name, $new_street, $new_city, $new_state);

            $result1 = $test_store->getStoreName();
            $result2 = $test_store->getStreet();
            $result3 = $test_store->getCity();
            $result4 = $test_store->getState();

            $this->assertEquals($new_store_name, $result1);
            $this->assertEquals($new_street, $result2);
            $this->assertEquals($new_city, $result3);
            $this->assertEquals($new_state, $result4);
        }
    }






 ?>
