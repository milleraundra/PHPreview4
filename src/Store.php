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
        
        function getState()
        {
            return $this->state;
        }


    }





 ?>
