<?php  

Trait Supplier {

use Database;

protected string $sup_table ="suppliers";

	public function CreateSupplier()
	{
		
		 	return "Yes";
		
	}


	public function updateSupplierDetails():bool
	{
		
		 	return true;
		
	}


	public function getAllSuppliers()
	{
		$query = "SELECT * FROM $this->sup_table ORDER BY id DESC LIMIT 100;";

		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();

		}else{
			$response = [];
		}
		$stmt = null;
		return $response;
	}

	public function countSuppliers()
	{
		$query = "SELECT count(`id`) as cnt FROM $this->sup_table WHERE status=1;";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function getAllSuppliersInDropDown()
	{
		$response = "";
		$stmt = $this->connect()->prepare("SELECT * FROM `$this->sup_table` ORDER BY id DESC LIMIT 100");
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			while ($row = $stmt->fetch()) {
				$response .= '<option value="' . $row->id . '">' . $row->company . '</option>';
			}
		}
		$stmt = null;
		return $response;
	}

	public function findSupplier($field,$value)
	{
		 $sql ="SELECT * FROM `{$this->sup_table}` WHERE `{$field}`=:field LIMIT 1;";
        $stmt = $this->connect()->prepare($sql);
       
        $type = gettype($value);
        $param_type = match ($type) {
            'integer' => PDO::PARAM_INT,
            'boolean' => PDO::PARAM_BOOL,
            default => PDO::PARAM_STR,
        };
        $stmt->bindParam('field', $value, $param_type);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $response = $stmt->fetch();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function fetchJsonSupplierById($id)
	{
		$query = "SELECT * FROM $this->sup_table WHERE id=:id LIMIT 1;";
		$stmt = $this->connect()->prepare($query);
		$stmt->bindValue(":id",$id,PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt =null;
			return json_encode($response);
		}
	}

}