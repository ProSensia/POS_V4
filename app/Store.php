<?php  

Trait Store {

use Database;

protected string $ware_table ="warehouses";

	public function CreateStore()
	{
		
		 	return "Yes";
		 
	}


	public function UpdateStoreData($name,$manager,$address,$phone,$status,$id)
	{
		
		 	return "Yes";
		
	}


	public function getAllStores()
	{
		$query = "SELECT * FROM $this->ware_table ORDER BY id DESC LIMIT 50;";

		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();

		}else{
			$response = [];
		}
		$stmt = null;
		return $response;
	}

	public function countStores($status)
	{
		$query = "SELECT count(`id`) as cnt FROM $this->ware_table WHERE status=?;";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$status]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function getAllStoresInDropDown()
	{
		$response = "";
		$stmt = $this->connect()->prepare("SELECT * FROM `$this->ware_table` ORDER BY id DESC LIMIT 50");
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			while ($row = $stmt->fetch()) {
				$response .= '<option value="' . $row->id . '">' . $row->store_name . '</option>';
			}
		}
		$stmt = null;
		return $response;
	}

	public function count_store():int 
	{
		$query = "SELECT count(`id`) as cnt FROM $this->ware_table";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function findStoreById($id)
	{
		$query = "SELECT * FROM $this->ware_table WHERE id=? LIMIT 1";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$id]);
		if ($stmt->rowCount() > 0) {
			return $stmt->fetch();
		}else{
			return false;
		}
	}


		public function fetchJsonWarehouseById($storeId)
	{
		$query = "SELECT * FROM $this->ware_table WHERE id=:Id LIMIT 1;";
		$stmt = $this->connect()->prepare($query);
		$stmt->bindParam(":Id",$storeId,PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt =null;
			return json_encode($response);
		}
	}


}