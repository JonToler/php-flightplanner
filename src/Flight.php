<?php
    class Flight
    {
        private $id;
        private $flight_number;
        private $departure_time;
        private $flight_status;

        function __construct($flight_number, $departure_time, $flight_status, $id = null)
        {
            $this->flight_number = $flight_number;
            $this->departure_time = $departure_time;
            $this->flight_status = $flight_status;
            $this->id = $id;
        }
//getters & setters
        function getId()
        {
            return $this->id;
        }

        function getFlightNumber()
        {
            return $this->flight_number;
        }

        function setFlightNumber($new_flight_number)
        {
            $this->flight_number = (string) $new_flight_number;
        }

        function getDepartureTime()
        {
            return $this->departure_time;
        }

        function setDepartureTime($new_departure_time)
        {
            $this->departure_time = (string) $new_departure_time;
        }

        function getFlightStatus()
        {
            return $this->flight_status;
        }

        function setFlightStatus($new_flight_status)
        {
            $this->flight_status = (string) $new_flight_status;
        }
//methods
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO flights (flight_number, departure_time, flight_status) VALUES   ('{$this->getFlightNumber()}', '{$this->getDepartureTime()}',     '{$this->getFlightStatus()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function update($new_flight_number)
        {
            $GLOBALS['DB']->exec("UPDATE flights SET flight_number = '{$new_flight_number}' WHERE id = {$this->getId()};");
            $this->setFlightNumber($new_flight_number);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM flights WHERE id = {$this->getId()};");
        }


        static function find($search_id)
        {
            $found_flight = null;
            $flights = Flight::getAll();
            foreach($flights as $flight) {
                $flight_id = $flight->getId();
                if ($flight_id == $search_id) {
                    $found_flight = $flight;
                }
            }
           return $found_flight;
        }
//static methods
        static function getAll()
        {
            $returned_flights = $GLOBALS['DB']->query("SELECT * FROM flights;");
            $flights = array();
            foreach($returned_flights as $flight) {
                $flight_number = $flight['flight_number'];
                $departure_time = $flight['departure_time'];
                $flight_status = $flight['flight_status'];
                $id = $flight['id'];
                $new_flight = new Flight($flight_number, $departure_time, $flight_status, $id);
                array_push($flights, $new_flight);
            }
            return $flights;
        }

        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM flights;");
        }
    }

?>
