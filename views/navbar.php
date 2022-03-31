<?php

$URLaction = $_GET["action"];

// Login button
$loginBtn = "<li><a href='{$_SERVER['PHP_SELF']}?action=login' class='btn ".
				isActive($URLaction, "login") ."'>Login</a></li>";

// List button
$listBtn = "<li><a href='{$_SERVER['PHP_SELF']}?action=list' class='btn ".
				isActive($URLaction, "list") ."'>Hotel List</a></li>";

// Add Hotel button.
$addHotelBtn = "<li><a href='{$_SERVER['PHP_SELF']}?action=add' class='btn ".
					isActive($URLaction, "add") ."'>Add New Hotel</a></li>";

// Split the user email at the point of @ and return the first part as the username.
if (isLoggedIn()) {
	$username = preg_split("/[@]+/", $_SESSION["user"])[0];

	// User and Logout dropdown.
	$userDropdown = "<li>
						<a class='user btn' href='#'>
							<i class='fas fa-user'></i>
							<span>{$username}</span>
						</a>
						<ul class='dropdown'>
							<li>
								<a href='{$_SERVER['PHP_SELF']}?action=logout' class='btn'>Logout</a>
							</li>
						</ul>
					</li>";
}

echo "<div id='title'><h1>Hotels <sup>4</sup>U</h1></div>
		<ul id='nav'>";
			// Show the list button.
			echo $listBtn;
			
			// If logged in...
			if (isLoggedIn()) {
				// If user is Admin, display the add hotel button.
				if (isAdmin()) echo $addHotelBtn;
				
				// Display the user dropdown and logout button.
				echo $userDropdown;
			}
			// Otherwise we're logged out, so display the login button.
			else echo $loginBtn;
	echo "</ul>";
?>