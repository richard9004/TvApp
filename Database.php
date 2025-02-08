<?php 

class Database {
    
    private PDO $connection;

    public function __construct(private $host, private $dbname, private $user, private $pass) {
         
           try {
               $this->connection = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->pass);
               $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           } catch (PDOException $e) {
               die("Database connection failed: " . $e->getMessage());
           }
        
    }

    public function getConnection(): ?PDO {
        return $this->connection;
    }
}