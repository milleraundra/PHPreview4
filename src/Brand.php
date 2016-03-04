<?php

    class Brand
    {
        private $brand_name;
        private $id;

        function __construct($brand_name, $id = null)
        {
            $this->brand_name = $brand_name;
            $this->id = $id;
        }

        function setBrandName($new_brand_name)
        {
            $this->brand_name = $new_brand_name;
        }

        function getBrandName()
        {
            return $this->brand_name;
        }

        // function setType($new_type)
        // {
        //     $this->type = $new_type;
        // }
        //
        // function getType()
        // {
        //     return $this->type;
        // }

        function getId()
        {
            return $this->id;
        }

        function adjustPunctuation($input)
        {
            $search = "/(\')/";
            $replace = "\'";
            $clean_input = preg_replace($search, $replace, $input);
            return $clean_input;
        }

        function save()
        {
            $this->setBrandName($this->adjustPunctuation($this->getBrandName()));
            $GLOBALS['DB']->exec("INSERT INTO brands (brand_name) VALUES ('{$this->getBrandName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands");
            $brands = array();
            foreach($returned_brands as $brand){
                $brand_name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
        }

        static function deleteAllJoin()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores_brands;");
        }

        static function find($id)
        {
            $all_brands = Brand::getAll();
            $found_brand = null;
            foreach($all_brands as $brand) {
                $brand_id = $brand->getId();
                if($brand_id == $id) {
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }

        function addStore($input_store)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM stores_brands WHERE store_id = {$input_store->getId()} AND brand_id = {$this->getId()};");
            $returned_stores = $query->fetchAll(PDO::FETCH_ASSOC);
            $already_saved = null;
            if ($returned_stores != []) {
                $already_saved = true;
            } else {
                $GLOBALS['DB']->exec("INSERT INTO stores_brands (store_id, brand_id) VALUES ({$input_store->getId()}, {$this->getId()});");
            }
            return $already_saved;
        }

        function getStores()
        {
            $query = $GLOBALS['DB']->query("SELECT stores.* FROM brands
                JOIN stores_brands ON (brands.id = stores_brands.brand_id)
                JOIN stores ON (stores_brands.store_id = stores.id)
                WHERE brands.id = {$this->getId()};");
            $returned_stores = $query->fetchAll(PDO::FETCH_ASSOC);
            $stores = array();
            foreach($returned_stores as $store) {
                $store_name = $store['store_name'];
                $street = $store['street'];
                $city = $store['city'];
                $state= $store['state'];
                $id = $store['id'];
                $new_store = new Store($store_name, $street, $city, $state, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        // function getNonmatchStores()
        // {
        //     $query = $GLOBALS['DB']->query("SELECT stores.* FROM brands
        //         JOIN stores_brands ON (brands.id = stores_brands.brand_id)
        //         JOIN stores ON (stores_brands.store_id <> stores.id)
        //         WHERE brands.id = {$this->getId()};");
        //     $returned_stores = $query->fetchAll(PDO::FETCH_ASSOC);
        //     $stores = array();
        //     foreach($returned_stores as $store) {
        //         $store_name = $store['store_name'];
        //         $street = $store['street'];
        //         $city = $store['city'];
        //         $state= $store['state'];
        //         $id = $store['id'];
        //         $new_store = new Store($store_name, $street, $city, $state, $id);
        //         array_push($stores, $new_store);
        //     }
        //     return $stores;
        // }
    }



 ?>
