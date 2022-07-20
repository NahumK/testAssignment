<?php 

function errorFlashMessage()
{	
	if (isset($_SESSION["error"])) {
		echo("<p style='color:red'><b>" . $_SESSION["error"] . "</b></p>\n");
		unset($_SESSION["error"]);
	}
}

function inputFieldDataValidation()
{
	if (strlen($_POST["sku"]) < 1 || strlen($_POST['name']) < 1 || strlen($_POST['price']) < 1) {
		$_SESSION['error'] = "Please, submit required data";
		return false;
	}

	if (!isset($_POST['attributes0']) || strlen($_POST['attributes0']) < 1) {
		$_SESSION['error'] = "Please, submit required data";
		return false;
	}

	if (isset($_POST['attributes1']) && isset($_POST['attributes2'])) {
		if (strlen($_POST['attributes1']) < 1 || strlen($_POST['attributes2']) < 1) {
			$_SESSION['error'] = "Please, submit required data";
			return false;
		}
	}

	if (!is_numeric($_POST['price'])) {
		$_SESSION['error'] = "Please, provide the data of indicated type";
		return false;
	}

	for ($i = 0; $i < 3; $i++) {
		$name = "attributes" . $i;
		if (isset($_POST[$name]) && !is_numeric($_POST[$name])) {
			$_SESSION['error'] = "Please, provide the data of indicated type";
			return false;
		}
	}

	return true;

}