<?php  

trait Receipt {

	use Database,Validator;

	public function transferProduct(array $req):string
	{
			

		return "Yes";
	}



	public function createCustomerOrder(array $req):string
	{
			
	
		return "Yes";
	}


	public function create_delivery_report(array $post):string
	{
		return "Yes";
	}

	protected function generateInvoiceNumber()
	{
		return "Yes";
	}

	public function getOrderDetailsById($orderId)
	{
		$sql ="SELECT * FROM `orders` WHERE `orderId`=:orderId LIMIT 1;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam('orderId', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $response = $stmt->fetch();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}


	public function getTransferDetailsById($Id)
	{
		$sql ="SELECT * FROM `transfers` WHERE `id`=:Id LIMIT 1;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam('Id', $Id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $response = $stmt->fetch();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

public function getOrderDetailsByInvoiceNo($invNo)
	{
		$sql ="SELECT * FROM `orders` WHERE `invoiceNo`=:invNo LIMIT 1;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':invNo', $invNo, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $response = $stmt->fetch();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function getDeliveryReport($invNo)
	{
		$sql ="SELECT * FROM `delivery_reports` WHERE `invoice_no`=:invNo LIMIT 1;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam(':invNo', $invNo, PDO::PARAM_STR);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $response = $stmt->fetch();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}
	public function getOrderItemsDetailsByOrderId($invoice_id)
	{
		$sql ="SELECT * FROM `order_items` WHERE `invoice_id`=:invoice_id;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam('invoice_id', $invoice_id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $response = $stmt->fetchAll();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function getTransferItemsDetailsByOrderId($invoice_id)
	{
		$sql ="SELECT * FROM `transfer_order_items` WHERE `invoice_id`=:invoice_id;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindParam('invoice_id', $invoice_id, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            $response = $stmt->fetchAll();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function getAllOrderDetailsPerSalesPerson($salepseron)
	{
		$sql ="SELECT * FROM `orders` WHERE cashier_name=? ORDER BY `orderId` DESC LIMIT 500;";
        $stmt = $this->connect()->prepare($sql);
          $stmt->execute([$salepseron]);
        if($stmt->rowCount() > 0){
            $response = $stmt->fetchAll();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function getAllOrderDetails()
	{
		$sql ="SELECT * FROM `orders` ORDER BY `orderId` DESC LIMIT 500;";
        $stmt = $this->connect()->prepare($sql);
          $stmt->execute();
        if($stmt->rowCount() > 0){
            $response = $stmt->fetchAll();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function getAllTransferDetails()
	{
		$sql ="SELECT * FROM `transfers` ORDER BY `id` DESC LIMIT 500;";
        $stmt = $this->connect()->query($sql);
        if($stmt->rowCount() > 0){
            $response = $stmt->fetchAll();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}


	public function getDeliveryReportList()
	{
		$sql ="SELECT * FROM `delivery_reports` ORDER BY `id` DESC LIMIT 500;";
        $stmt = $this->connect()->query($sql);
        if($stmt->rowCount() > 0){
            $response = $stmt->fetchAll();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function getSalesOrderReportsByDate($date_from,$date_to,$payment_type)
	{
		$query = "SELECT * FROM `orders` WHERE DATE(`trans_date`) BETWEEN ? AND ? ";
		if ($payment_type =='All') {
			// code...
			$query.= " ORDER BY orderId DESC ";
		}else{
			$query.= " AND `paymentType`='$payment_type' ORDER BY orderId DESC";
		}
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$date_from,$date_to]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt = null;
		}else{
		 $response = [];
		}
		return $response;
	}

	public function getTransferOrderReportsByDate($date_from,$date_to,$store_id)
	{
		$query = "SELECT * FROM `transfers` WHERE DATE(`created_at`) BETWEEN ? AND ? ";
		if (isset($store_id) && ! empty($store_id)) {
			// code...
			$query.= " AND to_store='$store_id' ";
		}else{
			$query.= " ORDER BY id DESC ";
		}
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$date_from,$date_to]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt = null;
		}else{
		 $response = [];
		}
		return $response;
	}

	public function getTodaySales()
	{
		$query = "SELECT sum(`discount_price`) as sales FROM `orders` WHERE DATE(`trans_date`) = DATE(CURRENT_DATE());";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}

	public function fetchTodaySalesByCashier($cahsier)
	{
		$query = "SELECT sum(`discount_price`) as sales FROM `orders` WHERE cashier_name=? AND DATE(`trans_date`) = DATE(CURRENT_DATE());";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$cahsier]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}

public function totalCurrentYearRevenue()
	{
		$query = "SELECT sum(`discount_price`) as sales FROM `orders` WHERE YEAR(trans_date) = YEAR(NOW());";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}
	public function getAllSalesInvoices()
	{
		$query = "SELECT count(`orderId`) as cnt FROM `orders`;";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function countTodaySalesInvoice()
	{
		$query = "SELECT count(`orderId`) as cnt FROM `orders` WHERE DATE(`trans_date`) = DATE(CURRENT_DATE());";
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->cnt;
		}else{
			return 0;
		}
	}

	// Count invoice by cashier
	public function countTodaySalesInvoiceByCashier($cashier)
	{
		$query = "SELECT count(`orderId`) as cnt FROM `orders` WHERE cashier_name=? AND DATE(`trans_date`) = DATE(CURRENT_DATE());";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$cashier]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->cnt;
		}else{
			return 0;
		}
	}

	// Count invoice by cashier
	public function countTotalSalesInvoiceByCashier($cashier)
	{
		$query = "SELECT count(`orderId`) as cnt FROM `orders` WHERE cashier_name=?;";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$cashier]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->cnt;
		}else{
			return 0;
		}
	}

	public function getCurrentMonthSalesrecord(){
		$query ="SELECT sum(`discount_price`) as sales FROM `orders` WHERE MONTH(trans_date) = MONTH(NOW()) AND YEAR(trans_date) = YEAR(NOW());"; 
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}

	public function getCurrentMonthSalesrecordByCashier($cashier){
		$query ="SELECT sum(`discount_price`) as sales FROM `orders` WHERE cashier_name=? AND MONTH(trans_date) = MONTH(NOW()) AND YEAR(trans_date) = YEAR(NOW());"; 
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$cashier]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}

	public function getLastSevenDaysSalesByCashier($cashier)
	{
		/*WHERE CreatedDate>= DATE_ADD(CURDATE(), INTERVAL -3 DAY);*/
		$query = "SELECT sum(`discount_price`) as sales FROM `orders` WHERE cashier_name=? AND DATE(`trans_date`) >= DATE_ADD(CURDATE(), INTERVAL -7 DAY);";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$cashier]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}

public function getCurrentYearRecordBySalesRep($cashier)
	{
		/*WHERE CreatedDate>= DATE_ADD(CURDATE(), INTERVAL -3 DAY);*/
		$query = "SELECT sum(`discount_price`) as sales FROM `orders` WHERE cashier_name=? AND YEAR(trans_date) = YEAR(NOW());";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$cashier]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}



public function getAllMyTotalSalesByCashier($cashier)
	{
		/*WHERE CreatedDate>= DATE_ADD(CURDATE(), INTERVAL -3 DAY);*/
		$query = "SELECT sum(`discount_price`) as sales FROM `orders` WHERE cashier_name=?;";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$cashier]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}

	public function getLastThreeMonthSalesrecord(){
		$query ="SELECT sum(`discount_price`) as sales FROM `orders` WHERE DATE(trans_date) >= (DATE(NOW()) - INTERVAL 3 MONTH) AND YEAR(trans_date) = YEAR(NOW());"; 
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}

	public function getLastSixMonthSalesrecord(){
		$query ="SELECT sum(`discount_price`) as sales FROM `orders` WHERE DATE(trans_date) >= (DATE(NOW()) - INTERVAL 6 MONTH) AND YEAR(trans_date) = YEAR(NOW());"; 
		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}

	public function getLastSevenDaysSales()
	{
		/*WHERE CreatedDate>= DATE_ADD(CURDATE(), INTERVAL -3 DAY);*/
		$query = "SELECT sum(`discount_price`) as sales FROM `orders` WHERE DATE(`trans_date`) >= DATE_ADD(CURDATE(), INTERVAL -7 DAY);";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute();
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->sales;
		}else{
			return 0;
		}
	}

	public function getAllTodaysTransactions()
	{
		$sql ="SELECT * FROM `orders` WHERE DATE(trans_date) = DATE(CURRENT_DATE()) ORDER BY `orderId` DESC LIMIT 10;";
        $stmt = $this->connect()->query($sql);
        if($stmt->rowCount() > 0){
            $response = $stmt->fetchAll();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function getAllTodaysTransactionsByCashier($cashier)
	{
		$sql ="SELECT * FROM `orders` WHERE cashier_name=? AND DATE(trans_date) = DATE(CURRENT_DATE()) ORDER BY `orderId` DESC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$cashier]);
        if($stmt->rowCount() > 0){
            $response = $stmt->fetchAll();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function getAllSalessTransactionsByCashier($cashier)
	{
		$sql ="SELECT * FROM `orders` WHERE cashier_name=? ORDER BY `orderId` DESC;";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$cashier]);
        if($stmt->rowCount() > 0){
            $response = $stmt->fetchAll();
              $stmt =null;
        }else{
            $response = [];
        }
        return $response;
	}

	public function getSalesOrderReportsByDateByCashier($date_from,$date_to,$payment_type,$cashier)
	{
		$query = "SELECT * FROM `orders` WHERE cashier_name=? AND DATE(`trans_date`) BETWEEN ? AND ? ";
		if ($payment_type =='All') {
			// code...
			$query.= " ORDER BY orderId DESC ";
		}else{
			$query.= " AND `paymentType`='$payment_type' ORDER BY orderId DESC";
		}
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$cashier,$date_from,$date_to]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();
			$stmt = null;
		}else{
		 $response = [];
		}
		return $response;
	}

	public function monthlySalesRecordByPaymentType($payment_method)
	{
		$query = "SELECT sum(`discount_price`) as total FROM `orders` WHERE paymentType=? AND MONTH(trans_date) = MONTH(NOW()) AND YEAR(trans_date) = YEAR(NOW());";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$payment_method]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->total;
		}else{
			return 0;
		}
	}

	public function monthlySalesRecordByPaymentTypeByCashier($payment_method,$cashier)
	{
		$query = "SELECT sum(`discount_price`) as total FROM `orders` WHERE paymentType=? AND cashier_name=? AND MONTH(trans_date) = MONTH(NOW()) AND YEAR(trans_date) = YEAR(NOW());";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$payment_method,$cashier]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetch();
			$stmt = null;
			return $response->total;
		}else{
			return 0;
		}
	}

	public function get_all_credit_sales():array 
	{
		$sql = "SELECT * FROM `orders` WHERE due > 0 ORDER BY orderId DESC;";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute();
		if ($stmt->rowCount()> 0) {
			return $stmt->fetchAll();
		}else{
			return [];
		}
	}

	public function get_all_credit_sales_records($cashier):array 
	{
		$sql = "SELECT * FROM `orders` WHERE due > 0 AND cashier_name=:cashier ORDER BY orderId DESC;";
		$stmt = $this->connect()->prepare($sql);

		$stmt->bindValue("cashier",$cashier,PDO::PARAM_STR);
		$stmt->execute();
		if ($stmt->rowCount()> 0) {
			return $stmt->fetchAll();
		}else{
			return [];
		}
	}

	public function receiveCreditorPayment(array $request):string
	{
		return "Yes";
	}


	 public function create_expense(array $data=[]):string
    {
        return "Yes";
    }


    public function update_expense(array $data=[]):string
    {
        return "Yes";
    }

    public function approve_disapprove_expenses(array $data=[]):string
    {
        return "Yes";
    }


    public function getAllExpenses()
	{
		$query = "SELECT * FROM expenses ORDER BY id DESC LIMIT 200;";

		$stmt = $this->connect()->query($query);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();

		}else{
			$response = [];
		}
		$stmt = null;
		return $response;
	}


    public function getAllExpensesByStoreId($wareId)
	{
		$query = "SELECT * FROM expenses WHERE warehouse_id=? ORDER BY id DESC LIMIT 500;";
		$stmt = $this->connect()->prepare($query);
		$stmt->execute([$wareId]);
		if ($stmt->rowCount() > 0) {
			$response = $stmt->fetchAll();

		}else{
			$response = [];
		}
		$stmt = null;
		return $response;
	}

}
