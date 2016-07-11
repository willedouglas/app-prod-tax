<?php 

include_once 'Config/Database.php';  
require_once 'Models/Category.php';

class CategoryDao {
    
    protected $Category;
    
	public function getCategories($id) {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Category = new Category();
		
		if (!is_null($id)) {
			$stmt = $db->prepare('SELECT * FROM ' . $Category->tableName . ' WHERE categoryNumber=' . $id);
		} else {
			$stmt = $db->prepare(
				'SELECT c.categoryNumber, c.categoryName, c.categoryDescription, t.taxName, t.taxPercentage
				FROM Categories AS c, Taxes AS t
				WHERE c.categoryTaxNumber = t.taxNumber ORDER BY categoryNumber DESC');	
		}
		
		$stmt->execute();
		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}
	
	public function insertCategory($category) {

		$database = new Database();
		$db = $database->getConnection();
		
		$Category = new Category();
		
	    $Category->categoryName = $category->categoryName;
	    $Category->categoryDescription = $category->categoryDescription;
	    $Category->categoryTaxNumber = $category->categoryTaxNumber;
	    
 		$stmt = $db->prepare('INSERT INTO ' . $Category->tableName . ' SET categoryName=:name, categoryDescription=:description, categoryTaxNumber=:tax');

	    $stmt->bindParam(":name", $Category->categoryName);
	    $stmt->bindParam(":description", $Category->categoryDescription);
	    $stmt->bindParam(":tax", $Category->categoryTaxNumber);
     
    	if ($stmt->execute()) {
        	return true;
    	} else {
        	echo "<pre>";
            	print_r($stmt->errorInfo());
	        echo "</pre>";
	        return false;
    	}
	}
	
	public function updateCategory($category) {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Category = new Category();
		
		$Category->categoryNumber = $category->id;
	    $Category->categoryName = $category->category->categoryName;
	    $Category->categoryDescription = $category->category->categoryDescription;
	    $Category->categoryTaxNumber = $category->category->categoryTaxNumber;
	    
 		$stmt = $db->prepare('UPDATE ' . $Category->tableName . ' SET categoryName=:name, categoryDescription=:description, categoryTaxNumber=:tax WHERE categoryNumber=:id');
		
		$stmt->bindParam(":id", $Category->categoryNumber);
	    $stmt->bindParam(":name", $Category->categoryName);
	    $stmt->bindParam(":description", $Category->categoryDescription);
	    $stmt->bindParam(":tax", $Category->categoryTaxNumber);

    	if ($stmt->execute()) {
        	return true;
    	} else {
        	echo "<pre>";
            	print_r($stmt->errorInfo());
	        echo "</pre>";
	        return false;
    	}
	}
	
	public function deleteCategory($id) {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Category = new Category();
		
		$stmt = $db->prepare('DELETE FROM ' . $Category->tableName . ' WHERE categoryNumber=' . $id);
		    	
		if ($stmt->execute()) {
        	return true;
    	} else {
        	echo "<pre>";
            	print_r($stmt->errorInfo());
	        echo "</pre>";
	        return false;
    	}
	}
}
?>