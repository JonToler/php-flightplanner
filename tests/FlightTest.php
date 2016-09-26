<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Flight.php";

    $server = 'mysql:host=localhost;dbname=flight_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class FlightTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Flight::deleteAll();
        }
// Test your getters and setters.
        function test_getFlightNumber()
        {
            //Arrange
            // no need to pass in id because it is null by default.
            $flight_number = "AUX345";
            $departure_time = "11:23";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);

            //Act
            $result = $test_flight->getFlightNumber();

            //Assert
            // id is null here, but that is not what we are testing. We are only interested in flight number.
            $this->assertEquals($flight_number, $result);
        }

        function test_setFlightNumber()
        {
            //Arrange
            $flight_number = "AUX345";
            $new_flight_number = "GUT456";
            $departure_time = "11:23";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);

            //Act
            $test_flight->setFlightNumber($new_flight_number);
            $result = $test_flight->getFlightNumber();

            //Assert
            $this->assertEquals($new_flight_number, $result);
        }

        function test_getDepartureTime()
        {
            //Arrange
            // no need to pass in id because it is null by default.
            $flight_number = "AUX345";
            $departure_time = "11:23";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);

            //Act
            $result = $test_flight->getDepartureTime();

            //Assert
            // id is null here, but that is not what we are testing. We are only interested in flight number.
            $this->assertEquals($departure_time, $result);
        }

        function test_setDepartureTime()
        {
            //Arrange
            $flight_number = "AUX345";
            $departure_time = "11:23";
            $new_departure_time = "12:45";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);

            //Act
            $test_flight->setDepartureTime($new_departure_time);
            $result = $test_flight->getDepartureTime();

            //Assert
            $this->assertEquals($new_departure_time, $result);
        }

        function test_getFlightStatus()
        {
            //Arrange
            // no need to pass in id because it is null by default.
            $flight_number = "AUX345";
            $departure_time = "11:23";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);

            //Act
            $result = $test_flight->getFlightStatus();

            //Assert
            // id is null here, but that is not what we are testing. We are only interested in flight number.
            $this->assertEquals($flight_status, $result);
        }

        function test_setFlightStatus()
        {
            //Arrange
            $flight_number = "AUX345";
            $departure_time = "11:23";
            $flight_status = "ON-TIME";
            $new_flight_status = "DELAYED";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);

            //Act
            $test_flight->setFlightStatus($new_flight_status);
            $result = $test_flight->getFlightStatus();

            //Assert
            $this->assertEquals($new_flight_status, $result);
        }

        function test_getId()
        {
            //Arrange
            $id = 1;
            $flight_number = "AUX345";
            $departure_time = "11:23";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status, $id);

            //Act
            $result = $test_flight->getId();

            //Assert
            $this->assertEquals($id, $result); //make sure id returned is the one we put in, not null.
        }

        function test_save()
        {
            //Arrange
            $flight_number = "AUX345";
            $departure_time = "11:23:00";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);
            $test_flight->save();
            //Act
            $result = Flight::getAll();
            //Assert
            $this->assertEquals($test_flight, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            // create more than one flight to make sure getAll returns them all.
            $flight_number = "AUX345";
            $departure_time = "11:23:00";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);
            $test_flight->save();
            $flight_number2 = "GUT456";
            $departure_time2 = "12:45:00";
            $flight_status2 = "DELAYED";
            $test_flight2 = new Flight($flight_number2, $departure_time2, $flight_status2);
            $test_flight2->save();
            //Act
            $result = Flight::getAll();
            //Assert
            $this->assertEquals([$test_flight, $test_flight2], $result);
        }

        function testDelete()
        {
            //Arrange
            $flight_number = "AUX345";
            $departure_time = "11:23:00";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);
            $test_flight->save();
            $flight_number2 = "GUT456";
            $departure_time2 = "12:45:00";
            $flight_status2 = "DELAYED";
            $test_flight2 = new Flight($flight_number2, $departure_time2, $flight_status2);
            $test_flight2->save();
            //Act
            $test_flight->delete();
            $result = Flight::getAll();
            //Assert
            $this->assertEquals([$test_flight2], $result);
        }

        function testFind()
        {
            //Arrange
            $flight_number = "AUX345";
            $departure_time = "11:23:00";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);
            $test_flight->save();

            $flight_number2 = "GUT456";
            $departure_time2 = "12:45:00";
            $flight_status2 = "DELAYED";
            $test_flight2 = new Flight($flight_number2, $departure_time2, $flight_status2);
            $test_flight2->save();
            //Act
            $result = Flight::find($test_flight->getId());
            //Assert
            $this->assertEquals($test_flight, $result);
        }

        function test_deleteAll()
        {
            //Arrange
            // create more than one flight
            $flight_number = "AUX345";
            $departure_time = "11:23:00";
            $flight_status = "ON-TIME";
            $test_flight = new Flight($flight_number, $departure_time, $flight_status);
            $test_flight->save();
            $flight_number2 = "GUT456";
            $departure_time2 = "12:45:00";
            $flight_status2 = "DELAYED";
            $test_flight2 = new Flight($flight_number2, $departure_time2, $flight_status2);
            $test_flight2->save();
            //Act
            Flight::deleteAll(); // delete them.
            $result = Flight::getAll(); // get all to make sure they are gone.
            //Assert
            $this->assertEquals([], $result);
        }
    }
?>
