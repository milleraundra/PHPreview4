<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Brand.php";

    $server = 'mysql:host=localhost;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function TearDown()
        {
            Brand::deleteAll();
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


    }





 ?>
