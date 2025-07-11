<?php  

Trait Product {

use Database;


protected string $table ="products";

	public function CreateProduct($batch,$item,$item_desc,$cost,$profit,$price,$qty,$barcode,$supplierId,$wareId,$mft_date,$expiry_date,$category,$today_date,$costTotal,$saleTotal)
	{
		$query = "INSERT INTO $this->table (batch,name,prod_desc,cost_price,profit,selling_price,qty,barcode,supId,wareId,mft_date,expiry_date,category,created_at,costTotal,salesTotal) VALUES (:batch,:name,:prod_desc,:cost_price,:profit,:selling_price,:qty,:barcode,:supplier,:wareId,:mft_date,:expiry_date,:category,:created_at,:costTotal,:saleTotal);";
		$stmt = $this->connect()->prepare($query);
		 $stmt->bindParam('batch', $batch, PDO::PARAM_STR);
		 $stmt->bindParam('name', $item, PDO::PARAM_STR);
		 $stmt->bindParam('prod_desc', $item_desc, PDO::PARAM_STR);
		 $stmt->bindParam('cost_price', $cost, PDO::PARAM_INT);
		 $stmt->bindParam('profit', $profit, PDO::PARAM_INT);
		 $stmt->bindParam('selling_price', $price, PDO::PARAM_INT);
		 $stmt->bindParam('qty', $qty, PDO::PARAM_INT);
		 $stmt->bindParam('barcode', $barcode, PDO::PARAM_STR);
		 $stmt->bindParam('supplier', $supplierId, PDO::PARAM_INT);
		 $stmt->bindParam('wareId', $wareId, PDO::PARAM_INT);
		 $stmt->bindParam('mft_date', $mft_date, PDO::PARAM_STR);
		 $stmt->bindParam('expiry_date', $expiry_date, PDO::PARAM_STR);
		 $stmt->bindParam('category', $category, PDO::PARAM_STR);
		 $stmt->bindParam('created_at', $today_date, PDO::PARAM_STR);
		 $stmt->bindParam('costTotal', $costTotal, PDO::PARAM_INT);
		 $stmt->bindParam('saleTotal', $saleTotal, PDO::PARAM_INT);
		 if ( $stmt->execute()) {
		 	return "Yes";
		 }else{
		 	return "";
		 }
	}

protected function import():string
  {
    
		 	return "Yes";
  }

	public function product_update()
	{
		
		 	return "Yes";
	
	}


		public function product_update_without_image()
	{
		
		 	return "Yes";
	}


	public function getAllProducts()
	{
		//WHERE qty > 0
		$query = "SELECT * FROM $this->table  ORDER BY created_at ASC LIMIT 1000;";

		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt = null;
		}else{
			$response = [];
		}
		
		return $response;
	}

	/*UPDATED VERSION OF PRODUCT IN A SPECIFIC STORE*/

	public function getAllProductsByStoreId(int $wareId):array
	{
		$query = "SELECT * FROM $this->table WHERE wareId=:wareId AND qty > 0 AND DATE(expiry_date) > DATE(CURRENT_DATE()) ORDER BY created_at ASC LIMIT 1000;";

		$stmt = $this->connect()->prepare($query);
		$stmt->bindValue(":wareId",$wareId,PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt = null;
		}else{
			$response = [];
		}
		
		return $response;
	}
	

	public function fetch_product_by_barcode($code)

	{
		$query = "SELECT * FROM $this->table WHERE barcode=? LIMIT 1;";

		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$code]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
		}else{
			$response ='';
		}
		
		return $response;
	}

	public function countProducts()
	{
		$query = "SELECT count(*) as cnt FROM $this->table WHERE qty > 0 AND expiry_date > DATE(CURRENT_DATE());";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function countProductsByStoreId($store_id):int
	{
		//AND expiry_date > DATE(CURRENT_DATE())
		$query = "SELECT count(proId) as cnt FROM $this->table WHERE wareId=? AND qty > 0 ;";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$store_id]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			return (int)$response->cnt;
		}else{
			return 0;
		}
	}

	public function countExpiredProducts()
	{
		$query = "SELECT count(`proId`) as cnt FROM $this->table WHERE DATE(expiry_date) <= DATE(CURRENT_DATE());";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function countExpiredProductsInSevenDaysTime()
	{
		$query = "SELECT count(`proId`) as cnt FROM $this->table WHERE DATE(expiry_date) <= DATE(CURRENT_DATE() + INTERVAL 7 DAY);";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function countExpiredProductsInThreeMonthTime()
	{
		$query = "SELECT count(`proId`) as cnt FROM $this->table WHERE DATE(expiry_date) <= DATE(CURRENT_DATE() + INTERVAL 3 MONTH);";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function countExpiredProductsInSixMonthTime()
	{
		$query = "SELECT count(`proId`) as cnt FROM $this->table WHERE DATE(expiry_date) <= DATE(CURRENT_DATE() + INTERVAL 6 MONTH);";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function countAllNewProducts()
	{
		$query = "SELECT count(`proId`) as cnt FROM $this->table WHERE DATE(created_at) >= DATE(CURRENT_DATE() - INTERVAL 10 DAY);";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function getAllProductsInDropDown()
	{
		$response = "";
		$stmt = $this->connect()->prepare("SELECT * FROM `$this->table` ORDER BY proId DESC LIMIT 200");
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			while ($row = $stmt->fetch()) {
		$response .= "<option value='".$row->proId ."'>".htmlspecialchars_decode($row->name)." &raquo; ".$row->category."</option>";
			}
		}
		return $response;
	}

	public function getAllProductsInDropDownByStoreId($wareId)
	{
		$response = "";
		$stmt = $this->connect()->prepare("SELECT * FROM $this->table WHERE wareId=? ORDER BY proId DESC LIMIT 500");
		$stmt->execute([$wareId]);
		if ($stmt->rowCount() > 0) {
			while ($row = $stmt->fetch()) {
		$response .= "<option value='".$row->proId ."'>".htmlspecialchars_decode($row->name)." &raquo; ".$row->category."</option>";
			}
		}
		return $response;
	}

	public function fetchJsonProductById($proId)
	{
		$query = "SELECT * FROM $this->table WHERE proId=:proId LIMIT 1;";
		$stmt = $this->connect()->prepare($query);
		$stmt->bindParam(":proId",$proId,PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt =null;
			return json_encode($response);
		}
	}

	public function searchProductByKeywords($keyword,$storeId)
	{
		$data = "%".$keyword."%";
		$query = "SELECT * FROM $this->table WHERE name LIKE ? AND wareId=? ORDER BY name ASC LIMIT 60;";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$data,$storeId]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt =null;
			return $response;
		}
	}

		public function getProductSalesRecordsById($proId)
	{
		$query = "SELECT * FROM order_items WHERE product_id=?";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$proId]);
		if ($stmt->rowCount() > 0) {
			return $stmt->fetchAll();
		}else{
			return null;
		}
	}

	public function fetchAllExpiredProducts()
	{
		$query = "SELECT * FROM $this->table WHERE DATE(expiry_date) <= DATE(CURRENT_DATE()) ORDER BY proId DESC LIMIT 200;";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt =null;
			return $response;
		}
	}

	public function fetchAllExpiredInSevenDaysTimes()
	{
		$query = "SELECT * FROM $this->table WHERE DATE(expiry_date) <= DATE(CURRENT_DATE() + INTERVAL 7 DAY) ORDER BY proId DESC LIMIT 200;";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt =null;
			return $response;
		}
	}

	public function fetchAllExpiredInThreeMonthTime()
	{
		//betweencurdate() AND curdate() + 2;
		$query = "SELECT * FROM $this->table WHERE DATE(`expiry_date`) <= DATE (CURRENT_DATE() + INTERVAL 3 MONTH) ORDER BY date(`expiry_date`) DESC LIMIT 200;";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt =null;
			return $response;
		}
	}

	public function fetchAllExpiredInSixMonthTime()
	{
		$query = "SELECT * FROM $this->table WHERE DATE(expiry_date) <= DATE(CURRENT_DATE() + INTERVAL 6 MONTH) ORDER BY proId DESC LIMIT 200;";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt =null;
			return $response;
		}
	}

	protected function get_store_worth($a,$b,$wareId)
	{
	    $sqlCostTotal = "SELECT wareId, SUM($a * $b) costTotal FROM products WHERE wareId=:wareId AND qty > 0;";
		$stmt = $this->connect()->prepare($sqlCostTotal);
		$stmt->bindValue(":wareId",$wareId,PDO::PARAM_INT);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			return $stmt->fetch()->costTotal;
		}else{
			return 0;
		}
	}

	public function getAllStockInWarehouse($store_id):array
	{
		$query ="SELECT * FROM $this->table WHERE wareId=? AND qty > 0 AND expiry_date > DATE(CURRENT_DATE());";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$store_id]);
		if ($stmt->rowCount() > 0) {
		return $stmt->fetchAll();
		}else{
			return [];
		}
	}
	

}