<?php
/* isLoggedIn function
 * Checks if user is logged in.
*/
function isLoggedIn() {
	if(isset($_SESSION["user"])) return true;
	else return false;
}
/* isAdmin function
 * Checks if user is an Admin.
 * user role: 1 = Not Admin, 2 = Admin
*/
function isAdmin() {
	if($_SESSION["userRole"] === "2") return true;
	else return false;
}

/* isActive function
 * For the navbar links.
 * Determines whether the nav link should be active
 * according to the action in the URL.
 */
function isActive($URLaction, $actionName) {
	if ($URLaction === $actionName) return "active";
}

/* goBackLink function
 * For the hotel details go back button.
 * Determines how to set the href of the button.
 */
function goBackLink($isNewHotel = false) {
	// If newhotel is true (a new hotel has been added)
	// OR the server http referer ISN'T set (by the browser),
	// then set the href to the list.
	if($isNewHotel === true || !isset($_SERVER['HTTP_REFERER']))
		return "{$_SERVER['PHP_SELF']}?action=list";
	
	// Otherwise, set the href to the referring page
	// (ie. previous page, specifically for the list search).
	else return $_SERVER['HTTP_REFERER'];
}

/* formatTime function
 * For the hotel details check in/out times.
 * Format the time as the 12hr clock without leading zeros, 
 * with minutes and am/pm.
 */
function formatTime($time) {
	return date('g:ia', strtotime($time));
}

/* validatePrice function
 * Validates the price according to min and max.
 */
function validatePrice($price, $min, $max) {
	// If price is less than min, return a string to check against.
	if ($price < $min) return "min";
	// If price is more than max, return a string to check against.
	elseif ($price > $max) return "max";
}

/* validateTimes function
 * Checks to see if the checkin and checkout
 * times have 2+ hours between them.
 */
function validateTimes($check_in, $check_out) {
	// Create new DateTime objects for checkout and checkin times.
	$checkout_time = new DateTime($check_out);
	$checkin_time = new DateTime($check_in);

	// Get the difference between the 2 times.
	$timeDifference = $checkout_time-> diff($checkin_time);
	// Format the time difference, HH:MM.
	$timeDiff_formatted = $timeDifference-> format('%H:%I');

	// If time difference is less than 2,
	// then checkout time is NOT 2+ hours before checkin time,
	// so return an array of false and the timeDiff_formatted for
	// usage in the error.
	
	// Works for both whole hours (01:00) and part hours (01:30).
	if ($timeDiff_formatted < 2) return [false, $timeDiff_formatted];
}

/* Errors function */
function errors($errors, $errorName) {
	if (!empty($errors)) {
		if($errorName === "login") {
			// If error login exists, call the errorHTML function to create the HTML and return it to this function.
			if(isset($errors["login"])) return errorHTML($errors["login"]);
		}
		elseif($errorName === "login_email") {
			if(isset($errors["login_email"])) return errorHTML($errors["login_email"]);
		}
		elseif($errorName === "login_password") {
			if(isset($errors["login_password"])) return errorHTML($errors["login_password"]);
		}
		elseif($errorName === "list") {
			if(isset($errors["list"])) return errorHTML($errors["list"]);
		}
		elseif($errorName === "details") {
			if(isset($errors["details"])) return errorHTML($errors["details"]);
		}
		elseif($errorName === "name") {
			if(isset($errors["name"])) return errorHTML($errors["name"]);
		}
		elseif($errorName === "stars") {
			if(isset($errors["stars"])) return errorHTML($errors["stars"]);
		}
		elseif($errorName === "price") {
			if(isset($errors["price"])) return errorHTML($errors["price"]);
		}
		elseif($errorName === "check_in") {
			if(isset($errors["check_in"])) return errorHTML($errors["check_in"]);
		}
		elseif($errorName === "check_out") {
			if(isset($errors["check_out"])) return errorHTML($errors["check_out"]);
		}
		elseif($errorName === "time") {
			if(isset($errors["time"])) return errorHTML($errors["time"]);
		}
		elseif($errorName === "location") {
			if(isset($errors["location"])) return errorHTML($errors["location"]);
		}
		elseif($errorName === "style") {
			if(isset($errors["style"])) return errorHTML($errors["style"]);
		}
		elseif($errorName === "amenities") {
			if(isset($errors["amenities"])) return errorHTML($errors["amenities"]);
		}
	}
}

/* newLine function
 * Converts the php newline \r\n in the string into html line break (<br>).
 */
function newLine($string) {
	return nl2br($string);
}

/* errorHTML function
 * Create the error HTML and return it to the parent function.
 */
function errorHTML($errorMsg) {
	return "<div class='error'><p>". newLine($errorMsg) ."</p></div>";
}
?>