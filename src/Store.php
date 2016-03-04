<?php

    class Store
    {
        private $store_name;
        private $street;
        private $city;
        private $state;
        private $id;

        function __construct($store_name, $street, $city, $state, $id = null)
        {
            $this->store_name = $store_name;
            $this->street = $street;
            $this->city = $city;
            $this->state = $state;
            $this->id = $id;
        }

        function setStoreName($new_store_name)
        {
            $this->store_name = $new_store_name;
        }

        function getStoreName()
        {
            return $this->store_name;
        }

        function setStreet($new_street)
        {
            $this->street = $new_street;
        }

        function getStreet()
        {
            return $this->street;
        }

        function setCity($new_city)
        {
            $this->city = $new_city;
        }

        function getCity()
        {
            return $this->city;
        }

        function setState($new_state)
        {
            $this->state = $new_state;
        }

        function getState()
        {
            return $this->state;
        }

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
            $this->setStoreName($this->adjustPunctuation($this->getStoreName()));
            $GLOBALS['DB']->exec("INSERT INTO stores (store_name, street, city, state) VALUES ('{$this->getStoreName()}', '{$this->getStreet()}', '{$this->getCity()}', '{$this->getState()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores");
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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
        }

        static function find($id)
        {
            $all_stores = Store::getAll();
            $found_store = null;
            foreach($all_stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        function update($new_store_name, $new_street, $new_city, $new_state)
        {
            $GLOBALS['DB']->exec("UPDATE stores SET store_name = '{$new_store_name}', street = '{$new_street}', city = '{$new_city}', state = '{$new_state}' WHERE id = {$this->getId()};");
            $this->setStoreName($new_store_name);
            $this->setStreet($new_street);
            $this->setCity($new_city);
            $this->setState($new_state);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()}");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
        }

        function addBrand($brand)
        {
            $query = $GLOBALS['DB']->query("SELECT * FROM stores_brands WHERE store_id = {$this->getId()} AND brand_id = {$brand->getId()};");
            $returned_entries = $query->fetchAll(PDO::FETCH_ASSOC);
            $already_saved = null;
            if ($returned_entries != []) {
                $alread_saved = true;
            } else {
                $GLOBALS['DB']->exec("INSERT INTO stores_brands(store_id, brand_id) VALUES ({$this->getId()}, {$brand->getId()});");
            }
            return $already_saved;
        }

        function getBrands()
        {
            $query = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN stores_brands ON (stores.id = stores_brands.store_id) JOIN brands ON (stores_brands.brand_id = brands.id) WHERE stores.id = {$this->getId()};");
            $returned_brands = $query->fetchAll(PDO::FETCH_ASSOC);
            $brands = array();
            foreach($returned_brands as $brand){
                $brand_name = $brand['brand_name'];
                $id = $brand['id'];
                $new_brand = new Brand($brand_name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        // function getNonmatchBrands()
        // {
        //     $query = $GLOBALS['DB']->query("SELECT brands.* FROM stores JOIN stores_brands ON (stores.id = stores_brands.store_id) JOIN brands ON (stores_brands.brand_id <> brands.id) WHERE stores.id = {$this->getId()};");
        //     $returned_brands = $query->fetchAll(PDO::FETCH_ASSOC);
        //     $brands = array();
        //     foreach($returned_brands as $brand){
        //         $brand_name = $brand['brand_name'];
        //         $id = $brand['id'];
        //         $new_brand = new Brand($brand_name, $id);
        //         array_push($brands, $new_brand);
        //     }
        //     return $brands;
        // }





    }





 ?>
