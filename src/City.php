<?php
    class City
    {
        private $id;
        private $city_name;

        function __construct($city_name, $id = null)
        {
            $this->city_name = $city_name;
            $this->id = $id;
        }
//getters & setters
        function getId()
        {
            return $this->id;
        }

        function getCityName()
        {
            return $this->city_name;
        }

        function setCityName($new_city_name)
        {
            $this->city_name = (string) $new_city_name;
        }

//methods
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO cities (city_name) VALUES ('{$this->getCityName()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

    //static methods

        static function find($search_id)
        {
           $found_city = null;
           $cities = city::getAll();
           foreach($cities as $city) {
               $city_id = $city->getId();
               if ($city_id == $search_id) {
                 $found_city = $city;
               }
           }
           return $found_city;
        }

        static function getAll()
        {
            $returned_cities = $GLOBALS['DB']->query("SELECT * FROM cities;");
            $cities = array();
            foreach($returned_cities as $city) {
                $city_name = $city['city_name'];
                $id = $city['id'];
                $new_city = new city($city_name, $id);
                array_push($cities, $new_city);
            }
            return $cities;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM cities;");
        }
    }

?>
