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




    }





 ?>
