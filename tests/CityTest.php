<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/City.php";

    $server = 'mysql:host=localhost;dbname=flight_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class CityTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            City::deleteAll();
        }

        function test_getCityName()
        {
            //Arrange
            // no need to pass in id because it is null by default.
            $city_name = "PDX";

            $test_city = new City($city_name);

            //Act
            $result = $test_city->getCityName();

            //Assert
            // id is null here, but that is not what we are testing. We are only interested in City number.
            $this->assertEquals($city_name, $result);
        }


        // Test your getters and setters.
        function test_getId()
        {
            //Arrange
            $id = 1;
            $city_name = "PDX";
            $test_city = new City($city_name, $id);

            //Act
            $result = $test_city->getId();

            //Assert
            $this->assertEquals($id, $result); //make sure id returned is the one we put in, not null.
        }

        function test_save()
        {
            //Arrange
            $city_name = "JFK";
            $test_city = new City($city_name);
            $test_city->save(); // id gets created by database and written in during save method.

            //Act
            $result = City::getAll();

            //Assert
            $this->assertEquals($test_city, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            // create more than one city to make sure getAll returns them all.
            $city_name = "JFK";
            $city_name2 = "PDX";
            $test_city = new City($city_name);
            $test_city->save();
            $test_city2 = new City($city_name2);
            $test_city2->save();

            //Act
            $result = City::getAll();

            //Assert
            $this->assertEquals([$test_city, $test_city2], $result);
        }

        function testFind()
        {
            //Arrange
            $city_name = "PDX";
            $id = 1;
            $test_city = new City($city_name, $id);
            $test_city->save();

            $city_name2 = "JFK";
            $id2 = 2;
            $test_city2 = new City($city_name2, $id2);
            $test_city2->save();

            //Act
            $result = City::find($test_city->getId());

            //Assert
            $this->assertEquals($test_city, $result);
        }
        function testDelete()
        {
            //Arrange
            $city_name = "PDX";
            $id = 1;
            $test_city = new City($city_name, $id);
            $test_city->save();

            $city_name2 = "JFK";
            $id2 = 2;
            $test_city2 = new City($city_name2, $id2);
            $test_city2->save();
            //Act
            $test_city->delete();
            $result = City::getAll();
            //Assert
            $this->assertEquals([$test_city2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            // create more than one city
            $city_name = "JFK";
            $city_name2 = "PDX";
            $test_city = new City($city_name);
            $test_city->save();
            $test_city2 = new City($city_name2);
            $test_city2->save();

            //Act
            City::deleteAll(); // delete them.
            $result = City::getAll(); // get all to make sure they are gone.

            //Assert
            $this->assertEquals([], $result);
        }
    }
?>
