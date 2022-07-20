<?php 
	
class Disc extends Product
{
	public function __construct(string $sku, string $name, float $price, $attributes, int $index)
	{	
		parent::__construct($sku, $name, $price, $attributes, $index);
	}	

	public function display(): void
	{
		$size = $this->attributes[0];
		$attrDescr = "Size: $size MB";
		$this->displayProduct($attrDescr);
	}

	public function save(PDO $pdo): void 
	{
		if (!$this->productExist($pdo)) {
			$typeIdx = array_search("Disc", self::TYPES);
			$id = $this->saveProduct($pdo, $this->sku, $this->name, $this->price, $typeIdx);
			$size = $this->attributes[0];

			$sql = "INSERT INTO Disc (size, product_id) VALUES (:size, :pId)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute(array(":size" => $size, ":pId" => $id));
		}
	}

}