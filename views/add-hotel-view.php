<!-- View -->

<h1>Add a new hotel</h1>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>?action=add" method="post" id="addHotel">
	<div class="row">
		<div class="form-control" id="name-control">
			<label for="name">Name:</label>
			<input type="text" id="name" name="name" value="<?php echo $newHotel["name"]; ?>">
		</div>
		<div class="form-control" id="price-control">
			<label for="price">Price per night:</label>
			<input type="number" id="price" name="price" value="<?php echo $newHotel["price"]; ?>" step="0.01">
		</div>
	</div>
	<div class="row errors">
		<?php echo errors($errors, "name"); ?>
		<?php echo errors($errors, "price"); ?>
	</div>
	<div class="row">
		<div class="form-control" id="stars-control">
			<fieldset>
				<span><legend>Star Rating:</legend></span>
				<label for="stars-1">
					<input type="radio" id="stars-1" name="stars" value="1" 
						<?php if($newHotel["stars"] === "1") echo "checked"; ?>>
					<div class="indicator"></div>
					<span>1 Star</span>
				</label>

				<label for="stars-2">
					<input type="radio" id="stars-2" name="stars" value="2" 
					<?php if($newHotel["stars"] === "2") echo "checked"; ?>>
				<div class="indicator"></div>
				<span>2 Stars</span>
				</label>

				<label for="stars-3">
					<input type="radio" id="stars-3" name="stars" value="3" 
						<?php if($newHotel["stars"] === "3") echo "checked"; ?>>
					<div class="indicator"></div>
					<span>3 Stars</span>
				</label>

				<label for="stars-4">
					<input type="radio" id="stars-4" name="stars" value="4" 
						<?php if($newHotel["stars"] === "4") echo "checked"; ?>>
					<div class="indicator"></div>
					<span>4 Stars</span>
				</label>

				<label for="stars-5">
					<input type="radio" id="stars-5" name="stars" value="5" 
						<?php if($newHotel["stars"] === "5") echo "checked"; ?>>
					<div class="indicator"></div>
					<span>5 Stars</span>
				</label>
			</fieldset>
		</div>
	</div>
	<div class="row errors">
		<?php echo errors($errors, "stars"); ?>
	</div>
	<div class="select-container">
		<div class="row">
			<div class="form-control" id="check-in-control">
				<label for="check-in">
					<span>Check-in:</span>
					<div class="overflow-ellipsis">
						<select id="check-in" name="check_in">
							<option value="" disabled selected>Please select an option.</option>
							<option value="12:00" <?php if($newHotel["check_in"] === "12:00") echo "selected"; ?>>12:00</option>
							<option value="13:00" <?php if($newHotel["check_in"] === "13:00") echo "selected"; ?>>13:00</option>
							<option value="14:00" <?php if($newHotel["check_in"] === "14:00") echo "selected"; ?>>14:00</option>
							<option value="15:00" <?php if($newHotel["check_in"] === "15:00") echo "selected"; ?>>15:00</option>
							<option value="16:00" <?php if($newHotel["check_in"] === "16:00") echo "selected"; ?>>16:00</option>
						</select>
					</div>
				</label>
			</div>
			<div class="form-control" id="check-out-control">
				<label for="check-out">
					<span>Check-out:</span>
					<div class="overflow-ellipsis">
						<select id="check-out" name="check_out">
							<option value="" disabled selected>Please select an option.</option>
							<option value="10:00" <?php if($newHotel["check_out"] === "10:00") echo "selected"; ?>>10:00</option>
							<option value="10:30" <?php if($newHotel["check_out"] === "10:30") echo "selected"; ?>>10:30</option>
							<option value="11:00" <?php if($newHotel["check_out"] === "11:00") echo "selected"; ?>>11:00</option>
							<option value="11:30" <?php if($newHotel["check_out"] === "11:30") echo "selected"; ?>>11:30</option>
							<option value="12:00" <?php if($newHotel["check_out"] === "12:00") echo "selected"; ?>>12:00</option>
						</select>
					</div>
				</label>
			</div>
		</div>
		<div class="row errors">
			<?php echo errors($errors, "check_in"); ?>
			<?php echo errors($errors, "check_out"); ?>
			<?php echo errors($errors, "time"); ?>
		</div>
		<div class="row">
			<div class="form-control" id="location-control">
				<label for="location">
					<span>Location:</span>
					<div class="overflow-ellipsis">
						<select id="location" name="location">
							<option value="" disabled selected>Please select an option.</option>
							<?php foreach($locations as $location) {
								// If postback variable equals the location array id,
								// then add a selected attribute.
								$selectedAttr = ($newHotel["location"] === $location["id"]) ? "selected" : "";

								echo "<option value='{$location["id"]}' {$selectedAttr}>{$location["location"]}</option>";
							} ?>
						</select>
					</div>
				</label>
			</div>
			<div class="form-control" id="style-control">
				<label for="style">
					<span>Style:</span>
					<div class="overflow-ellipsis">
						<select id="style" name="style">
							<option value="" disabled selected>Please select an option.</option>
							<?php foreach($styles as $style) {
								// If postback variable equals the style array id,
								// then add a selected attribute.
								$selectedAttr = ($newHotel["style"] === $style["id"]) ? "selected" : "";

								echo "<option value='{$style["id"]}' {$selectedAttr}>{$style["name"]}</option>";
							} ?>
						</select>
					</div>
				</label>
			</div>
		</div>
		<div class="row errors">
			<?php echo errors($errors, "location"); ?>
			<?php echo errors($errors, "style"); ?>
		</div>
	</div>
	<div class="row form-control" id="amenities-control">
		<fieldset>
			<div class="col">
				<legend>Amenities:</legend>
			</div>
			<div class="col amenities">
				<?php foreach($amenities as $amenity) {
					// Replace the spaces in the name with underscore(_) to use for the input id.
					$inputID = str_replace(' ', '_', $amenity["name"]);

					if(!empty($newHotel["amenities"]) && in_array($amenity["id"], $newHotel["amenities"]))
						$checkedAttr = "checked";
					else $checkedAttr = "";

					echo "<label for='{$inputID}'>";
					echo "<input type='checkbox' id='{$inputID}' name='amenities[]' value='{$amenity["id"]}' {$checkedAttr}>";
					echo "<div class='indicator'></div>";
					echo "<span>{$amenity["name"]}</span></label>";
				} ?>
			</div>
		</fieldset>
	</div>
	<div class="row errors">
		<?php echo errors($errors, "amenities"); ?>
	</div>
	<div class="form-control btns">
		<input type="submit" name="submitBtn" id="submitBtn" class="btn" value="Add Hotel">
		<input type="reset" name="resetBtn" id="resetBtn" class="btn" value="Reset Form">
	</div>
</form>