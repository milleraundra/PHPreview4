<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";
    require_once "src/Store.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function TearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
            Brand::deleteAllJoin();
        }

        function test_allGetters()
        {
            $brand_name = "Converse";
            $id = 4;
            $test_brand = new Brand($brand_name, $id);

            $result1 = $test_brand->getBrandName();
            $result3 = $test_brand->getId();

            $this->assertEquals($brand_name, $result1);
            $this->assertEquals($id, is_numeric($result3));
        }

        function test_save()
        {
            $brand_name = "Converse";
            $test_brand = new Brand($brand_name, null);

            $test_brand->save();
            $result = Brand::getAll();

            $this->assertEquals([$test_brand], $result);
        }

        function test_getAll()
        {
            $brand_name = "Converse";
            $test_brand = new Brand($brand_name, null);
            $test_brand->save();

            $brand_name2 = "Nike";
            $test_brand2 = new Brand ($brand_name2, null);
            $test_brand2->save();

            $result = Brand::getAll();

            $this->assertEquals([$test_brand, $test_brand2], $result);
        }

        function test_deleteAll()
        {
            $brand_name = "Converse";
            $test_brand = new Brand($brand_name, null);
            $test_brand->save();

            $brand_name2 = "Nike";
            $test_brand2 = new Brand ($brand_name2, null);
            $test_brand2->save();

            Brand::deleteAll();
            $result = Brand::getAll();

            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $brand_name = "Converse";
            $test_brand = new Brand($brand_name, null);
            $test_brand->save();

            $brand_name2 = "Nike";
            $test_brand2 = new Brand ($brand_name2, null);
            $test_brand2->save();

            $result = Brand::find($test_brand->getId());

            $this->assertEquals($test_brand, $result);
        }

        function test_addStore()
        {
            //Arrange
            $brand_name = "Converse";
            $test_brand = new Brand($brand_name, null);
            $test_brand->save();

            $store_name = "Payless";
            $street = "392 SW Washington St.";
            $city = "Oregon City";
            $state = "OR";
            $test_store = new Store($store_name, $street, $city, $state, null);
            $test_store->save();

            //Act
            $test_brand->addStore($test_store);
            $result = $test_brand->getStores();

            //Assert
            $this->assertEquals([$test_store], $result);
        }

        function test_getStores()
        {
            //Arrange
            $brand_name = "Converse";
            $test_brand = new Brand($brand_name, null);
            $test_brand->save();

            $store_name = "What";
            $street = "392 SW Washington St.";
            $city = "Oregon City";
            $state = "OR";
            $test_store = new Store($store_name, $street, $city, $state, null);
            $test_store->save();

            $store_name = "Where";
            $street = "180 SW Washington St.";
            $city = "Clackamas";
            $state = "OR";
            $test_store2 = new Store($store_name, $street, $city, $state, null);
            $test_store2->save();

            // //Act
            // $test_brand->addStore($test_store);
            // $test_brand->addStore($test_store2);
            // $result = $test_brand->getStores();
            //
            // //Assert
            // $this->assertEquals([$test_brand, $test_brand2], $result);
        }


    }





 ?>
