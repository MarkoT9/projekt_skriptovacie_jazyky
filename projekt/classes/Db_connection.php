<?php
class Db_connection {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "dashboard";
    private $conn;

    public function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        return $this->conn;
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>