<!-- View -->

<h1>Hotel List</h1>
<form method="GET" action="<?php echo $_SERVER['PHP_SELF'] ?>?action=list" id="search">
	<!-- A hidden input to send the action for the URL query string parameters. -->
	<input id="action" name="action" type="hidden" value="<?php echo $_GET['action']; ?>">

	<div class="form-control">
		<label for="search">Search by Hotel Name: </label>
		<input id="search" name="search" type="search" value="<?php echo $search ?>">
	</div>
	<div class="form-control btns">
		<input id="submit" name="submit" type="submit" class="btn">
		<input id="reset" name="reset" type="submit" class="btn" value="Reset">
	</div>
</form>
<div class="row outputMsg <?php if ($errors) echo "errors"; ?>">
	<?php
		echo "<p>". newLine($outputMsg) ."</p>";
		if ($errors) echo errors($errors, "list");
	?>
</div>
<?php
	if ($hotels) {
		echo "<ul id='hotelList'>";

		foreach ($hotels as $hotel) {
			echo "<li>
					<a href='{$_SERVER['PHP_SELF']}?action=details&id={$hotel["id"]}' class='listItem btn'>{$hotel["name"]}</a>
				</li>";
		}
		echo "</ul>";
	}
?>