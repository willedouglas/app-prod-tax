<?php 

include_once 'Config/Database.php';  
require_once 'Models/Product.php';

class ProductDao {
    
    protected $Product;
    
	public function getProducts($id) {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Product = new Product();
		
		if (!is_null($id)) {
			$stmt = $db->prepare('SELECT * FROM ' . $Product->tableName . ' WHERE productNumber=' . $id);
		} else {
			$stmt = $db->prepare(
				'SELECT p.productNumber, p.productName, p.productDescription, p.productPrice,c.categoryName
				FROM Products AS p, Categories AS c
				WHERE p.productCategoryNumber = c.categoryNumber ORDER BY productNumber DESC');	
		}
		
		$stmt->execute();
		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}
	
	public function insertProduct($product) {

		$database = new Database();
		$db = $database->getConnection();
		
		$Product = new Product();
		
	    $Product->productName = $product->productName;
	    $Product->productDescription = $product->productDescription;
	    $Product->productPrice = $product->productPrice;
	    $Product->productCategoryNumber = $product->productCategoryNumber;
	    
 		$stmt = $db->prepare('INSERT INTO ' . $Product->tableName . ' SET productName=:name, productDescription=:description, productPrice=:price, productCategoryNumber=:category');

	    $stmt->bindParam(":name", $Product->productName);
	    $stmt->bindParam(":description", $Product->productDescription);
	    $stmt->bindParam(":price", $Product->productPrice);
	    $stmt->bindParam(":category", $Product->productCategoryNumber);
     
    	if ($stmt->execute()) {
        	return true;
    	} else {
        	echo "<pre>";
            	print_r($stmt->errorInfo());
	        echo "</pre>";
	        return false;
    	}
	}
	
	public function updateProduct($product) {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Product = new Product();
	
		$Product->productNumber = $product->id;
	    $Product->productName = $product->product->productName;
	    $Product->productDescription = $product->product->productDescription;
	    $Product->productPrice = $product->product->productPrice;
	    $Product->productCategoryNumber = $product->product->productCategoryNumber;
	    
 		$stmt = $db->prepare('UPDATE ' . $Product->tableName . ' SET productName=:name, productDescription=:description, productPrice=:price, productCategoryNumber=:category WHERE productNumber=:id');
		
		$stmt->bindParam(":id", $Product->productNumber);
	    $stmt->bindParam(":name", $Product->productName);
	    $stmt->bindParam(":description", $Product->productDescription);
	    $stmt->bindParam(":price", $Product->productPrice);
	    $stmt->bindParam(":category", $Product->productCategoryNumber);

    	if ($stmt->execute()) {
        	return true;
    	} else {
        	echo "<pre>";
            	print_r($stmt->errorInfo());
	        echo "</pre>";
	        return false;
    	}
	}
	public function deleteProduct($id) {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Product = new Product();
		
		$stmt = $db->prepare('DELETE FROM ' . $Product->tableName . ' WHERE productNumber=' . $id);
		    	
		if ($stmt->execute()) {
        	return true;
    	} else {
        	echo "<pre>";
            	print_r($stmt->errorInfo());
	        echo "</pre>";
	        return false;
    	}
	}
	
	public function getProductInvoices() {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Product = new Product();
		
		$stmt = $db->prepare(
				'SELECT p.productNumber, p.productName, p.productDescription, p.productPrice,c.categoryName, t.taxName, t.taxPercentage
				FROM Products AS p, Categories AS c, Taxes AS t
				WHERE p.productCategoryNumber = c.categoryNumber AND c.categoryTaxNumber = t.taxNumber ORDER BY productNumber DESC');
		
		$stmt->execute();
		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}
}
?>