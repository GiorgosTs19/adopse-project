<?php
class DatabaseConnection
{
    private $servername = "--";
    private $dbusername = "--";
    private $dbpassword = "--";

    private static $conn;

    private function __construct(){}

    public static function connect()
        {

            //now lets check if a connection exists already in our $conn property, then we should return it instead of recreating a new connection
            if(!empty(self::$conn))
                {
                    return self::$conn;
                }
            try
                {
                    $dbh = new PDO("mysql:host=localhost;dbname=adopse", 'adopse', 'Adopse@2022', array(PDO::ATTR_PERSISTENT => true));

                    //lets now assign the database connection to our $conn property
                    self::$conn = $dbh;

                    //return the connection
                    return $dbh;

                }
            catch (PDOException $e)
                {
                    print "Error! : " . $e->getMessage() . "<br/>";
                    die();
                }
        }
}
