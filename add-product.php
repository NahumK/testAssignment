<?php 
	
require_once("pdo.php");
require_once("utilities.php");

session_start();

spl_autoload_register(function ($class) {
    include $class . '.php';
});

if (isset($_POST['cancel'])) {
	header("Location:index.php");
	return;
}

if (isset($_POST['save'])) {
	// inputFieldDataValidation function is defined in the utilities file.
	if (inputFieldDataValidation()) {
		$type = $_POST["type"];
		$sku = $_POST["sku"];
		$name = $_POST["name"];
		$price = $_POST["price"];

		$attributes = array();

		for ($i = 0; $i < 3; $i++) {
			$key = "attributes" . $i;
			if(isset($_POST[$key]))
				$attributes[$i] = $_POST[$key];
		}

		$product = new $type($sku, $name, $price, $attributes, 0);
		$product->save($pdo);

		header("Location: index.php");
		return;
	} else {
		header("Location: add-product.php");
		return;
	}
}

?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Product Add</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
   			 	integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    			integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<style>input{position: absolute;left: 160px;}</style>
		<script src="js/script.js"></script>
	</head>

	<body>
		<div class="container">
			<div class="header">
			<h2>Product Add</h2>
			<div id="buttons">
				<button type="submit" name="save" form="product_form">Save</button>
				<button type="submit" name="cancel" form="product_form">Cancel</button>
			</div>
			</div>
			<hr>
			<div><?php errorFlashMessage(); // defined in the utilities file ?></div>
			<form id="product_form" method="post" action="add-product.php">
				<p>SKU <input type="text" name="sku" id="sku"></p>
				<p>Name <input type="text" name="name" id="name"></p>
				<p>Price ($) <input type="text" name="price" id="price"></p>
				<p>Type Switcher 
					<select id="productType" name="type" onclick="addAttributeFields()">
						<option value="" selected>Type Switcher</option>
						<option value="Disc">DVD</option>
						<option value="Book">Book</option>
						<option value="Furniture">Furniture</option>
					</select>
				</p>
				<div id="attributes"></div>
			</form>
		</div>
	</body>

</html>