<?php 

require_once("pdo.php");

spl_autoload_register(function ($class) {
    include $class . '.php';
});

$products = Product::fetchProducts($pdo);

if (isset($_POST['delete'])) {
	foreach ($_POST as $key => $index) {
		if (is_numeric($index)) {
			$product = $products[$index];
			$product->delete($pdo);
		}
	}

	header("Location: index.php");
	return;
}

if (isset($_POST['add'])) {
	header("Location: add-product.php");
	return;
}

?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Product List</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
   			 	integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    			integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="css/style.css">
	</head>

	<body>
		<div class="container">
			<div class="header">
			<h2>Product List</h2>
			<div id="buttons">
				<button type="submit" name="add" form="products">ADD</button>
				<button type="submit" name="delete" id="delete-product-btn" form="products">MASS DELETE</button>
			</div>
			</div>
			<hr>
			<form method="post" action="index.php" id="products">
				<?php Product::displayProducts($products, $pdo) ?>
			</form>
		</div>
	</body>

</html>