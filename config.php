<?php  

	require_once 'vendor/autoload.php';

	// Database credentials. running Mysql server with username "root" and password "2468"

	define ('DB_SERVER', 'localhost');
	define ('DB_USERNAME', 'root');
	define ('DB_PASSWORD', '');
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

    
    // init configuration
    $clientID = '1078554237877-urrdb83ucs0kj521djur4edg29gg83e4.apps.googleusercontent.com';
    $clientSecret = '81KerqUE1KJjAvMS3PD-MmnO';
    $redirectUri = 'http://localhost/work/perrypay/redirect.php';
    
    // create Client Request to access Google API
    $client = new Google_Client();
    $client->setClientId($clientID);
    $client->setClientSecret($clientSecret);
    $client->setRedirectUri($redirectUri);
	$client->setApplicationName("Perry Pays");
    $client->addScope("email");
    $client->addScope("https://www.googleapis.com/auth/plus.login");

?>