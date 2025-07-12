<?php

trait Coupon
{

	use Database;

	protected string $ctable = "promo_tbl";

	public function CreateCoupon($coupon_code, $discount, $expiry_date, $status = 'active')
	{
		$query = "INSERT INTO $this->ctable (coupon, discount, expiry_date, status, created_at) 
              VALUES (:coupon, :discount, :expiry_date, :status, :created_at);";

		$stmt = $this->connect()->prepare($query);
		$created_at = date("Y-m-d H:i:s");

		$stmt->bindParam(":coupon", $coupon_code, PDO::PARAM_STR);
		$stmt->bindParam(":discount", $discount, PDO::PARAM_STR);
		$stmt->bindParam(":expiry_date", $expiry_date, PDO::PARAM_STR);
		$stmt->bindParam(":status", $status, PDO::PARAM_STR);
		$stmt->bindParam(":created_at", $created_at, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "Yes";
		} else {
			$error = $stmt->errorInfo();
			return "DB ERROR: " . $error[2];
		}
	}



	public function getAllCoupons()
	{
		$query = "SELECT * FROM $this->ctable ORDER BY id DESC LIMIT 50;";

		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();

		} else {
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

	public function count_coupons(): int
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