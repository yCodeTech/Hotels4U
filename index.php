<?php
session_start();

// Start output buffering
// (prevents all html output from reaching the page and instead stores it internally).
ob_start();

include "includes/db-connection.php";
include "models/hotel-model.php";
include "controllers/hotel-controller.php";

include 'views/header.php';

// Declare a new variable to work with later.
$pageTitle = null;

if(isset($_GET["action"])){
	$action = $_GET['action'];
}
else {
	$action = "list";
}
// If action NOT login AND user ISN'T logged in...
if($action != "login" && !isLoggedIn()) {
	// Redirect to the login page.
	header("Location: {$_SERVER['PHP_SELF']}?action=login");
}
/* Login */
// If action is login OR user ISN'T logged in...
if ($action === "login" || !isLoggedIn()) {
	login();
	$pageTitle = "Login";
}
/* Logout */
elseif ($action === "logout") {
	logout();
}
/* Browseable List */
elseif ($action === "list") {
	viewList();
	$pageTitle = "Browse hotels";
}
/* Hotel Details */
// If action is details AND the id is set in the URL parameters...
elseif ($action === "details" && isset($_GET['id'])) {
	$hotelName = details();
	$pageTitle = "{$hotelName} hotel";
}
/* Add New Hotel */
elseif ($action === "add") {
	// Restrict access to this page to only Admin.
	if (!isAdmin()) {
		// The user doesn't have Admin privileges to access this page.
		// Send a 403 forbidden HTTP response to the server and show the 403 view.
		http_response_code(403);
		include "views/403-view.php";
	}
	else {
		addHotel();
		$pageTitle = "Add a new hotel";
	}
}
/* Page not found?? */
else {
	// Send a 404 forbidden HTTP response to the server and show the 404 view.
	http_response_code(404);
	include "views/404-view.php";
}

include 'views/footer.php';

/* pageBuffer function
 *
 * ob_start() atop this file stops any HTML/output reaching the page
 * and stores the output internally.
 * This is then used to be able to change the title of the page 
 * before sending everything to the page.
 *
 * Based on an answer from StackOverflow: https://stackoverflow.com/a/32337830/2358222
 */
function pageBuffer($pageTitle) {
	// Get the contents of the internal buffer and store it as a variable to be.
	$buffer = ob_get_contents();
	// Erase and disable the internal output buffer.
	ob_end_clean();

	// If page title is set, get the title and add the site/company name on to it,
	// otherwise just set the title as the site/company name.
	$pageTitle = (isset($pageTitle)) ? $pageTitle . " | Hotels 4 U" : "Hotels 4 U";
	// In the buffer, find and replace the <title> tag with the new page title.
	$buffer = str_replace("<title></title>", "<title>{$pageTitle}</title>", $buffer);
	
	// Return the buffer output to the function.
	return $buffer;
}
// Echo out the whole page including new page title.
echo pageBuffer($pageTitle);
?>