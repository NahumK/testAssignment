<?php 

class Furniture extends Product
{

	public function __construct(string $sku, string $name, float $price, $attributes, int $index)
	{	
		parent::__construct($sku, $name, $price, $attributes, $index);
	}	

	public function display(): void
	{	
		$height = $this->attributes[0];
		$width = $this->attributes[1];
		$length = $this->attributes[2];
		$attrDescr = "Dimension: $height". "x" . $width . "x" . $length;
		$this->displayProduct($attrDescr);
	}

	public function save(PDO $pdo): void 
	{
		if (!$this->productExist($pdo)) {
			$typeIdx = array_search("Furniture", self::TYPES);
			$id = $this->saveProduct($pdo, $this->sku, $this->name, $this->price, $typeIdx);
			$height = $this->attributes[0];
			$width = $this->attributes[1];
			$length = $this->attributes[2];

			$sql = "INSERT INTO Furniture (height, width, length, product_id) VALUES (:ht, :wi, :lt, :pId)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(":ht" => $height, ":wi" => $width, ":lt" => $length, ":pId" => $id));
		}
	}

}