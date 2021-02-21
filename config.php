<?php  

// Database credentials. running Mysql server with username "root" and password "2468"

define ('DB_SERVER', 'localhost');
define ('DB_USERNAME', 'root');
define ('DB_PASSWORD', '2468');
define ('DB_NAME', 'perrypays');

// Attempt to connect to database
try {
	$pdo = new PDO("mysql:host=". DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
	// Set the PDO error mode to Exception
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    # Print host information
    //  echo "Connect Successfully. Host info: " . 
    //  $pdo->getAttribute(constant("PDO::ATTR_CONNECTION_STATUS"));
} catch (PDOException $e) {
	die ("ERROR: Could not connect." . $e->getMessage());
}



?>