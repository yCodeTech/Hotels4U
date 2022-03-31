<?php
/* Model */

/* Login */
function validatePassword($email, $password) {
	$conn = connection();
	$prepare = $conn-> prepare("SELECT * FROM users WHERE email = :email");
	$prepare-> bindValue(':email', $email);
	$prepare-> execute();

	if($row = $prepare-> fetch()){
		if (password_verify($password, $row['password'])) {

			// Set role session.
			$_SESSION["userRole"] = $row['role'];
			
			return true;
		}
	}
	closeConnection($conn);
}

/* Browseable List */

// Select all hotels function
function selectAll() {
	$conn = connection();

	$query = "SELECT * FROM hotels";
	$resultset = $conn-> query($query);

	closeConnection($conn);
	return $resultset-> fetchAll();
}
// Select all hotels where name relates to a search term function
function search($search) {
	$conn = connection();

	$query = "SELECT * FROM hotels WHERE name LIKE :search";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':search', '%'. $search .'%');
	$prepare-> execute();

	closeConnection($conn);
	return $prepare-> fetchAll();
}

/* Details */
function getDetails($hotelID) {
	$conn = connection();

	$query = "SELECT *, hotels.name AS name, styles.name AS style FROM hotels
				INNER JOIN locations ON hotels.location_id = locations.id
				INNER JOIN styles ON hotels.style_id = styles.id
				WHERE hotels.id = :id";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $hotelID);
	$prepare-> execute();

	$hotel = $prepare-> fetch();

	$query = "SELECT amenities.name as amenityName FROM hotels
				INNER JOIN amenity_hotel ON hotels.id = amenity_hotel.hotel_id
				INNER JOIN amenities ON amenity_hotel.amenity_id = amenities.id
				WHERE hotels.id = :id";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':id', $hotelID);
	$prepare-> execute();

	$amenities = $prepare-> fetchAll();

	closeConnection($conn);

	if ($hotel && $amenities) return ["hotel" => $hotel, "amenities" => $amenities];
	else return false;
}

/* Add Hotel */

// Get hotel attributes (locations, styles, amenities)
// Using one function to avoid 3 near-identical code...
function getHotelAttr($tableName) {
	$conn = connection();

	$query = "SELECT * FROM {$tableName}";
	$result = $conn-> query($query);

	closeConnection($conn);
	return $result->fetchAll();
}

/* Insert hotel function */
function insertHotel($newHotel) {
	$conn = connection();

	$name = $newHotel["name"];
	$stars = $newHotel["stars"];
	$price = $newHotel["price"];
	$check_in = $newHotel["check_in"];
	$check_out = $newHotel["check_out"];
	$location = $newHotel["location"];
	$style = $newHotel["style"];
	$amenities = $newHotel["amenities"];

	$query = "INSERT INTO hotels (id, name, stars, price, check_in, check_out, location_id, style_id)
				VALUES (NULL, :name, :stars, :price, :check_in, :check_out, :location_id, :style_id)";
	$prepare = $conn-> prepare($query);
	$prepare-> bindValue(':name', $name);
	$prepare-> bindValue(':stars', $stars);
	$prepare-> bindValue(':price', $price);
	$prepare-> bindValue(':check_in', $check_in);
	$prepare-> bindValue(':check_out', $check_out);
	$prepare-> bindValue(':location_id', $location);
	$prepare-> bindValue(':style_id', $style);
	$prepare-> execute();

	// Insert the amenities for the new hotel.

	// Get the ID of the new hotel (last inserted row ID).
	$hotelID = $conn-> lastInsertId();

	// Loop through the amenities array and insert each amenity ID into the database
	// along with the new hotel ID.
	foreach($amenities as $amenityID) {
		$query = "INSERT INTO amenity_hotel (amenity_id, hotel_id)
			VALUES (:amenity_id, :hotel_id)";
		$prepare = $conn-> prepare($query);
		$prepare-> bindValue(':amenity_id', $amenityID);
		$prepare-> bindValue(':hotel_id', $hotelID);
		$prepare-> execute();
	}
	closeConnection($conn);
	return $hotelID;
}

?>