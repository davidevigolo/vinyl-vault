<?php
class DbConnection{
private const HOST_DB = "tecweb_mysql";
	private const DATABASE_NAME = "tecweb_db";
	private const USERNAME = "tecweb_user";
	private const PASSWORD = "tecweb_password";

	private $connection;

	public function openDBConnection() {
		$this->connection = mysqli_connect($this::HOST_DB, $this::USERNAME, $this::PASSWORD, $this::DATABASE_NAME);
	}

	public function closeConnection() {
		mysqli_close($this->connection);
	}
    public function getConnection() {
        return $this->connection;
    }
}
?>