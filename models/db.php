<?php


class DB
{

    private static $instance;
    private $connection;

    /**
     * @return DB
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            // make instance if there is none
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return PDO
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * DB constructor.
     */
    private function __construct()
    {
        include('/home/jbencehu/db/credentials.php');
        try {
            $this->connection = new PDO("mysql:host=localhost;dbname=$database", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {

            die("Connection failed: " . $e->getMessage());
        }
    }

    /**
     * This magic method is defined and it is empty in order to prevent double connection.
     */
    private function __clone()
    {
    }

}

