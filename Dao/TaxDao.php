<?php 

include_once 'Config/Database.php';  
require_once 'Models/Tax.php';

class TaxDao {
    
    protected $Tax;
    
	public function getTaxes($id) {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Tax = new Tax();
		
		if (!is_null($id)) {
			$stmt = $db->prepare('SELECT * FROM ' . $Tax->tableName . ' WHERE taxNumber=' . $id);
		} else {
			$stmt = $db->prepare('SELECT * FROM ' . $Tax->tableName . ' ORDER BY taxNumber DESC');	
		}
		
		$stmt->execute();
		
		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		return $results;
	}
	
	public function insertTax($tax) {

		$database = new Database();
		$db = $database->getConnection();
		
		$Tax = new Tax();
		
	    $Tax->taxName = $tax->taxName;
	    $Tax->taxDescription = $tax->taxDescription;
	    $Tax->taxPercentage = $tax->taxPercentage;
	    
 		$stmt = $db->prepare('INSERT INTO ' . $Tax->tableName . ' SET taxName=:name, taxDescription=:description, taxPercentage=:percentage');

	    $stmt->bindParam(":name", $Tax->taxName);
	    $stmt->bindParam(":description", $Tax->taxDescription);
	    $stmt->bindParam(":percentage", $Tax->taxPercentage);
     
    	if ($stmt->execute()) {
        	return true;
    	} else {
        	echo "<pre>";
            	print_r($stmt->errorInfo());
	        echo "</pre>";
	        return false;
    	}
	}
	
	public function updateTax($tax) {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Tax = new Tax();
		
		$Tax->taxNumber = $tax->id;
	    $Tax->taxName = $tax->tax->taxName;
	    $Tax->taxDescription = $tax->tax->taxDescription;
	    $Tax->taxPercentage = $tax->tax->taxPercentage;
	    
 		$stmt = $db->prepare('UPDATE ' . $Tax->tableName . ' SET taxName=:name, taxDescription=:description, taxPercentage=:percentage WHERE taxNumber=:id');
		
		$stmt->bindParam(":id", $Tax->taxNumber);
	    $stmt->bindParam(":name", $Tax->taxName);
	    $stmt->bindParam(":description", $Tax->taxDescription);
	    $stmt->bindParam(":percentage", $Tax->taxPercentage);

    	if ($stmt->execute()) {
        	return true;
    	} else {
        	echo "<pre>";
            	print_r($stmt->errorInfo());
	        echo "</pre>";
	        return false;
    	}
	}
	public function deleteTax($id) {
		
		$database = new Database();
		$db = $database->getConnection();
		
		$Tax = new Tax();
		
		$stmt = $db->prepare('DELETE FROM ' . $Tax->tableName . ' WHERE taxNumber=' . $id);
		    	
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