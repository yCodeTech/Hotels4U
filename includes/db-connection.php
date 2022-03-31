<?php
// Errors appear because without running they are undefined global variables that are defined in the config file.


function connection() {
	// Global variables for DB connection details stored outside the htdocs.
	include_once '../../../../config.php';

	
	/* Less secure way for details...
	$host = 'localhost';
	$dbname = 'assignment';
	$username = 'assignment';
	$password = '****'; */

	try {

		/* Less secure way of establishing a connection.
		$conn = new PDO("mysql:host={$host};dbname={$dbname}", $username, $password); */
		
		$conn = new PDO(DB_SOURCE, DB_USER, DB_PASSWORD);
		echo "<script>console.error('PHP error reporting is on. Please turn off on live sites.');</script>";
		$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	}
	catch (PDOException $exception) {
		echo "Oh no, there was a problem<br>" . $exception->getMessage();
	}
	return $conn;
}
function closeConnection($conn) {
	$conn = null;
}
?>