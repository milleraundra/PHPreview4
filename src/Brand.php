<?php

    class Brand
    {
        private $brand_name;
        private $type;
        private $id;

        function __construct($brand_name, $type, $id = null)
        {
            $this->brand_name = $brand_name;
            $this->type = $type;
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

        function setType($new_type)
        {
            $this->type = $new_type;
        }

        function getType()
        {
            return $this->type;
        }

        function getId()
        {
            return $this->id;
        }
    }



 ?>
