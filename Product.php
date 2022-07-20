<?php 

abstract class Product
{
	// These two constants store the column names and the names of the Tables as designed in the Database.
	private const COLUMN_NAMES = array(array("weight"), array("height", "width", "length"), array("size"));
	protected const TYPES = array("Book", "Furniture", "Disc");

	/* 
	   - The attributes parameter is a 1 value array for the Book/Disc child classes and a 3 value array for the 
	   Furniture child class.
	   - The index parameter is used to keep track of the position of the object in the array where all objects 
	   are store after beeing fetch from the Database.
	*/
	public function __construct(
		protected string $sku, 
		protected string $name, 
		protected float $price, 	
		protected $attributes, 							
		protected int $index
	) {

	}

	abstract public function display(): void;
	abstract public function save(PDO $pdo): void;

	// Check if a product with the same  sku is already stored in the Database.
	protected function productExist(PDO $pdo): bool 
	{
		$sql = "SELECT * FROM Product WHERE sku = :sku";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(":sku" => $this->sku));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if($row)
			return true;

		return false;
	}

	/*
		Save all the general attributes shared by all Productstypes in the "Product"-Table in the Database and return 
		the primary key of that "Product"-Table which will be used as a foreign key in the "Type"-Tables in the Database.
	*/
	protected function saveProduct(PDO $pdo, $sku, $name, $price, $type): int
	{
		$sql = "INSERT INTO Product (sku, name, price, type) VALUES (:sku, :nm, :pr, :ty)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(":sku" => $sku, ":nm" => $name, ":pr" => $price, ":ty" => $type));

		$id = $pdo->lastInsertId();
		return $id;
	}

	/*
		The general structure for all Productstypes when displayed is the same. Just the description of the attributes specific to the Type is different. This function takes that specific description related to the Type as parameter and is called by the Type to provide that description.
	*/
	protected function displayProduct(string $attrDescr): void
	{
		$sku = htmlentities($this->sku);
		$name = htmlentities($this->name);
		$price = $this->price;

		echo("<div class='product'><br>\n");
		echo("<input type='checkbox' class='delete-checkbox' value='$this->index' name='delete" . $this->index . "'>\n");
		echo("$sku <br> $name <br> $price \$ <br> $attrDescr <br></div>\n");
	}

	public function delete(PDO $pdo): void 
	{
		$sql = "DELETE FROM Product WHERE sku = :sku";
		$stmt = $pdo->prepare($sql);
		$stmt->execute(array(":sku" => $this->sku));
	}

	// Retrieve all the products sorted by primary key from the Database and store them in an array that is returned. 
	public static function fetchProducts(PDO $pdo): array
	{
		$products = array();
		$sql = "SELECT * FROM Product ORDER BY product_id";               
		$stmt = $pdo->query($sql);
		$productsIndex = 0;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$id = $row["product_id"];
			$sku = $row["sku"];
			$name = $row["name"];
			$price = $row["price"];
			$typeIdx = $row["type"];

			$type = self::TYPES[$typeIdx];
			$columns = self::COLUMN_NAMES[$typeIdx];
			$len = count($columns);
			$attributes = array();

			$sql = "SELECT * FROM $type WHERE product_id = $id";
			$stmtType = $pdo->query($sql);
			$rowType = $stmtType->fetch(PDO::FETCH_ASSOC);

			for($index = 0; $index < $len; $index++)
			{
				$column = $columns[$index];
				$attributes[$index] = $rowType[$column];
			}

			$product = new $type($sku, $name, $price, $attributes, $productsIndex);
			$products[$productsIndex] = $product;
			$productsIndex++;
		}

		return $products;
	}

	public static function displayProducts($products, $pdo): void
	{
		$len = count($products);

		for ($index = 0; $index < $len; $index++) {
			$product = $products[$index];
			$product->display($pdo);
		}
	}

}