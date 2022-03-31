<?php
/* Controller */

include "includes/functions.php";

/* Login */
function login() {
	$email = "";
	$errors = [];
	
	if(isset($_POST['submit'])){

		$email = $_POST['email'];
		$password = $_POST['password'];
		
		// If email field is empty, throw error.
		if (empty($email)) {
			$errors["login_email"] = "Please enter your email address.";
		}
		// If email fails validation (not a proper email address), throw error.
		elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errors["login_email"] = "Email address is not valid.\r\nEmail needs to be in the form of name@domain.extension, \r\ne.g. me@example.com";
		}
		// If password field is empty, throw error.
		elseif(empty($password)) {
			$errors["login_password"] = "Please enter your password.";
		}
		// Otherwise continue with password validation...
		else {
			// Use the function in the model to validate the password via the database.
			// If password fails validation, throw error.
			if (!validatePassword($email, $password)) {
				$errors["login"] = "Wrong login details, please try again.";
			}
			// Otherwise the validation was successful, so we login...
			else {
				// Set login session
				$_SESSION["user"] = $email;

				// Logged in.

				// Redirect to the main page.
				header("Location: index.php?action=list");
			}
		}
	} // If isset submit

	include "views/login-view.php";
}
/* Logout */
function logout() {
	// Unset all session keys...
	session_unset();
	
	// Set a loggedout session so we can print a logged out message.
	$_SESSION["loggedout"] = "You've been logged out.";
	
	// Go to login.
	header("Location: {$_SERVER['PHP_SELF']}?action=login");
}
/* Browseable List */
function viewList() {
	$search = "";
	$outputMsg = "";
	$errors = [];

	// On page load
	if (!isset($_GET['submit']) && !isset($_GET['reset'])) {
		$hotels = selectAll();
		$outputMsg .= "Showing all hotels.";
	}
	// If reset
	elseif (isset($_GET['reset'])) {
		// Show all hotels to reset everything.
		$hotels = selectAll();

		$outputMsg .= "The list is now reset and is showing all hotels.";
	}
	// If submit
	else {
		// If search not empty
		if (!empty($_GET['search'])) {
			$search = $_GET['search'];

			// Run the search function in the Model
			$hotels = search($search);
			
			// Output the term searched.
			$outputMsg .= "You searched \"<b>{$search}</b>\".\r\n";

			// If the hotel array exists,
			if ($hotels) {
				$outputMsg .= "Here are the results.";
			}
			// Otherwise, error
			else $errors["list"] = "No matching hotels were found.";
		}
		// Otherwise, search is empty...
		else {
			// No search term? Show all hotels instead.
			$hotels = selectAll();
			$outputMsg .= "You didn't enter a search term.\r\nShowing all hotels instead.";
		}
	}
	
	include "views/browseable-list-view.php";
}
/* Hotel Details */
function details() {
	$hotelID = $_GET['id'];
	// Get details from the model
	$hotelDetails = getDetails($hotelID);
	$errors = [];
	
	if (!$hotelDetails) {
		$errors["details"] = "No Records Found";
	}
	
	include "views/details-view.php";

	// If hotel details is not false, then return the hotel name
	// so that we can use it for the page title; otherwise return null.
	return ($hotelDetails != false) ? $hotelDetails["hotel"]["name"] : null;
}
/* Add New Hotel */
function addHotel() {
	// For use in the form (to add all the locations/styles/amenities).
	// (Dev note: vscode displays these variables as unused, they are used but in the view file.)
	$locations = getHotelAttr("locations");
	$styles = getHotelAttr("styles");
	$amenities = getHotelAttr("amenities");

	$errors = [];
	$newHotel = [];
	$amenitiesArray = [];

	// Initialise the variables for the postback form to work.
	$newHotel["name"] = "";
	$newHotel["stars"] = "";
	$newHotel["price"] = "";
	$newHotel["check_in"] = "";
	$newHotel["check_out"] = "";
	$newHotel["location"] = "";
	$newHotel["style"] = "";
	$newHotel["amenities"] = "";

	if(isset($_POST['submitBtn'])) {
		/* Name */
		if (empty($_POST['name'])) {
			$errors["name"] = "Please enter the hotel name.";
		}
		else {
			$newHotel["name"] = trim($_POST['name']);
			// If less than 5 characters OR is not letters only, error...
			if (strlen($newHotel["name"]) < 5 || ctype_alpha($newHotel["name"]) === false) {
				$errors["name"] = "Please make sure the hotel name is 5 characters or more and is letters only.";
			}
		}
		/* Star Rating */
		if (!isset($_POST['stars'])) {
			$errors["stars"] = "Please select a star rating.";
		}
		else {
			$newHotel["stars"] = $_POST['stars'];
		}
		/* Price */
		if (empty($_POST['price'])) {
			$errors["price"] = "Please enter the price.";
		}
		else {
			$newHotel["price"] = trim($_POST['price']);
			$minPrice = 25;
			$maxPrice = 200;
			// Validate Price and return a value.
			$validate = validatePrice($newHotel["price"], $minPrice, $maxPrice);

			// If price fails validation, throw errors...
			// Min Price
			if ($validate === "min") {
				$errors["price"] = "The price is too low. The minimum is £{$minPrice} per night. Please adjust the price accordingly.";
			}
			// Max Price
			elseif ($validate === "max") {
				$errors["price"] = "The price is too high. The maximum is £{$maxPrice} per night. Please adjust the price accordingly.";
			}
		}
		/* Check-in */
		if (!isset($_POST['check_in'])) {
			$errors["check_in"] = "Please select the check-in time.";
		}
		else {
			$newHotel["check_in"] = $_POST['check_in'];
		}
		/* Check-out */
		if (!isset($_POST['check_out'])) {
			$errors["check_out"] = "Please select the check-out time.";
		}
		else {
			$newHotel["check_out"] = $_POST['check_out'];

			$check_in = $newHotel["check_in"];
			$check_out = $newHotel["check_out"];
			
			// Validate the check in and out times and get a value back from the function.
			$validateTimes = validateTimes($check_in, $check_out);

			// If validateTimes is an array, then the validation failed, so throw errors.
			if (is_array($validateTimes)) {
				// Get the time difference from the array.
				$timeDiff_format = $validateTimes[1];

				$errors["time"] = "The times you chose are: <b>check-in at {$check_in}</b> and <b>check-out at {$check_out}</b>, these have a time difference of <b>{$timeDiff_format}</b>.\r\n";
				$errors["time"] .= "The check-out time must be at least 2 hours before the check-in time. Please choose different times.";
			}
		} // End if else checkout

		if (!isset($_POST['location'])) {
			$errors["location"] = "Please select the location of the hotel.";
		}
		else {
			$newHotel["location"] = $_POST['location'];
		}

		if (!isset($_POST['style'])) {
			$errors["style"] = "Please select a hotel style.";
		}
		else {
			$newHotel["style"] = $_POST['style'];
		}

		if (!isset($_POST['amenities'])) {
			$errors["amenities"] = "Please select the hotel amenities.";
		}
		else {
			$amenitiesArray = $_POST['amenities'];
			$newHotel["amenities"] = $amenitiesArray;
		}

		// If errors array is empty (no errors).
		if(empty($errors)) {

			// Call the insert hotel function from the model
			// and insert into the database.
			// And get back the ID.
			$hotelID = insertHotel($newHotel);

			// Go to the details page using the ID.
			header("Location: {$_SERVER['PHP_SELF']}?action=details&newhotel=true&id={$hotelID}");
		}
	} // End if isset submit
	
	include "views/add-hotel-view.php";
}
?>