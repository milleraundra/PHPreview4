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
        function test_allGetters()
        {
            $brand_name = "Converse";
            $type = ["Sneaker", "High-tops", "Lace-up"];
            $id = 4;
            $new_brand = new Brand($brand_name, $type, $id);

            $result1 = $new_brand->getBrandName();
            $result2 = $new_brand->getType();
            $result3 = $new_brand->getId();

            $this->assertEquals($brand_name, $result1);
            $this->assertEquals($type, $result2);
            $this->assertEquals($id, is_numeric($result3));
        }



    }





 ?>
