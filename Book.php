<?php 

class Book extends Product
{

	public function __construct(string $sku, string $name, float $price, $attribute, int $index)
	{	
		parent::__construct($sku, $name, $price, $attribute, $index);
	}	

	public function display(): void
	{
		$weight = $this->attributes[0];
		$attrDescr = "Weight: $weight KG";
		$this->displayProduct($attrDescr);
	}

	public function save(PDO $pdo): void 
	{
		if (!$this->productExist($pdo)) {
			$typeIdx = array_search("Book", self::TYPES);
			$id = $this->saveProduct($pdo, $this->sku, $this->name, $this->price, $typeIdx);
			$weight = $this->attributes[0];

			$sql = "INSERT INTO Book (weight, product_id) VALUES (:weight, :pId)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(":weight" => $weight, ":pId" => $id));
		}
	}
}