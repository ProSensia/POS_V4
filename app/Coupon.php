<?php  

Trait Coupon {

use Database;

protected string $ctable ="promo_tbl";

	public function CreateCoupon()
	{
		
		 	return "Yes";
		 
	}


	public function getAllCoupons()
	{
		$query = "SELECT * FROM $this->ctable ORDER BY id DESC LIMIT 50;";

		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();

		}else{
			$response = [];
		}
		$stmt = null;
		return $response;
	}

	public function countCoupons($status)
	{
		$query = "SELECT count(`id`) as cnt FROM $this->ctable WHERE status=?;";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$status]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->cnt;
		}
	}

	public function getAllCouponsInDropDown()
	{
		$response = "";
		$stmt = $this->connect()->prepare("SELECT * FROM `$this->ctable` ORDER BY id DESC LIMIT 50");
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			while ($row = $stmt->fetch()) {
				$response .= '<option value="' . $row->id . '">' . $row->coupon . '</option>';
			}
		}
		$stmt = null;
		return $response;
	}

	public function count_coupons():int 
	{
		$query = "SELECT count(`id`) as cnt FROM $this->ctable";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->cnt;
		}
	}

}