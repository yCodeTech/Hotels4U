<?php

/* View */

// If newhotel parameter exists in the url query string...
if (isset($_GET["newhotel"])) {
	// A new hotel has been added...

	// Call the goBackLink function with the parameter [$newHotel] as true and get the href.
	$gobackLinkHref = goBackLink(true);

	// And echo a confirmation.
	echo "<div class='row'><h2>Added the new hotel {$hotelDetails["hotel"]["name"]}. Here are the details:</h2></div>";
}
// Otherwise, call the goBackLink function and get the href of the referring page for the list search.
else $gobackLinkHref = goBackLink();
?>

<div class="row goBack">
	<a href="<?php echo $gobackLinkHref; ?>" class="btn"><i class="fas fa-reply"></i>Go back to the list</a>
</div>
<div id="details_container">

	<?php
	if ($hotelDetails) {
		$hotel = $hotelDetails["hotel"];

		// Format the times as am/pm.
		$checkin = formatTime($hotel['check_in']);
		$checkout = formatTime($hotel['check_out']);

		$amenities = $hotelDetails["amenities"];

		echo "<h1 class='name'>{$hotel['name']}";
		echo "<span class='price'>£{$hotel['price']} <sup>per night</sup></span>";
		echo "</h1>";

		echo "<div class='row'>";

		echo "<div class='col'>";
		echo "<p>Star Rating: ";
		echo "<span class='stars star-{$hotel['stars']}'>";

		for ($i = 0; $i < 5; $i++) {
			echo '<i class="fas fa-star"></i>';
		}
		echo "</span>"; // End .stars
		echo "</p>";

		echo "<p>Location: {$hotel['location']}</p>";
		echo "<p>Style: {$hotel['style']}</p>";
		echo "</div>"; // End .col

		echo "<div class='col'>";
		echo "<p>Check-in: {$checkin}</p>";
		echo "<p>Check-out: {$checkout}</p>";
		echo "</div>";

		echo "</div>";
	
		echo "<div class='row' id='amenities'>";
		echo "<span>Amenities:</span>";
		echo "<ul class='row'>";
		foreach ($amenities as $amenity) {
			echo "<li>{$amenity['amenityName']}</li>";
		}
		echo "</ul>";
		echo "</div>";
	}	
	?>
	<?php
		// Errors...
		if(!empty($errors)) {
			echo '<div class="row errors">';
			echo errors($errors, "details");
			echo '</div>';
		}
	?>
</div> <!-- End .details_container -->