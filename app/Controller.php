<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

require 'vendor/autoload.php';
require_once "User.php";
require_once "Validator.php";
require_once "Product.php";
require_once "Supplier.php";
require_once "Store.php";
require_once "Category.php";
require_once "Receipt.php";
require_once "Utils.php";

class Controller extends User
{
    use Validator, Product, Supplier, Store, Category, Receipt;
    public function __construct()
    {

        if (!Controller::isAuthor()) {
            die("<center><h1 style='color:red;' class='text-center'>Please contact the Developer <a href='https://www.flaterptech.com' title='Contact Flat ERP Technologies'>Click Here</a></h1></center>");
        }
        if (str_ends_with($_SERVER['REQUEST_URI'], ".php") or stripos($_SERVER['REQUEST_URI'], ".php")) {
            $this->redirect("auth-404");
        }

        //$this->deleteExpiredAccount();
    }


    public function auto_log_out(): void
    {
        //3600
        if (isset($_SESSION['last_activity']) && time() - $_SESSION['last_activity'] > 3600) {
            session_destroy();
            $this->redirect("/");
        }

    }

    public function getStoreWorth($a, $b, $wareId)
    {
        return $this->get_store_worth($a, $b, $wareId);
    }

    public function generateCustomerReceipt(array $request)
    {
        return $this->premium_notification();
    }

    public function productTrsanfer(array $request)
    {
        return $this->premium_notification();
    }

    public function submit_creditor_payment(array $request)
    {
        return $this->premium_notification();
    }


    public function app()
    {
        echo APP_NAME[0] . " " . APP_VERSION;
    }

    public function app_short()
    {
        echo APP_NAME[1];
    }

    public function app_alert_msg()
    {
        return $this->alert("success", $this->displayApplicationName());
    }

    public function getUsers()
    {
        return $this->index();
    }

    protected static function MyStr(): string
    {
        return strrev(self::showMENow());
    }
    public function loginUser(array $request)
    {
        $email = $this->validate($request['email_address']);
        $password = $this->validate($request['password']);
        if ($this->isEmptyStr($email) || $this->isEmptyStr($password)) {
            $response = $this->toast("error", "Please enter login information");
        } elseif (!$this->is_valid_email($email)) {
            $response = $this->toast("error", "Please enter a valid e-mail address");
        } else {
            $response = $this->login($email, $password);
        }
        return $response;
    }

    public function copyRight()
    {
        echo '<div class="col-12 text-center mt-2 text-info">
            <strong><span>' . APP_COPYRIGHT . ' <span>' . APP_NAME[0] . ' ' . APP_VERSION . '</strong></span>.<br><span class="text-danger">Powered by:</span>
              <a href="https://flaterptech.com" target="_blank" class="text-primary">' . strrev(APP_AUTHOR) . '</a></span></div>';
    }

    public function logOutAdmin($user_id, $email)
    {

        $request = $this->logout_admin($user_id, $email);
        if ($request === "Logout successful") {

            $response = "logout";
        } else {
            $response = "notlogout";
        }
        return $response;

    }

    public function logOutCashier($user_id, $email)
    {

        $request = $this->logout_cashier($user_id, $email);
        if ($request === "User Logout successful") {

            $response = "logout";
        } else {

            $response = "notlogout";
        }
        return $response;

    }
    public function checkUserLoggedIn()
    {
        if (!$this->isLoggedInUser()) {
            session_destroy();
            $this->redirect("./");
        }
    }


    public function addProduct(array $request)
{
    $batch = $request['batch'] ?? '';
    $item = $request['item'] ?? '';
    $item_desc = $request['item_desc'] ?? '';
    $cost = (float) ($request['cost'] ?? 0);
    $price = (float) ($request['item_price'] ?? 0);
    $qty = (int) ($request['item_qty'] ?? 0);
    $profit = $price - $cost;
    $barcode = $request['barcode'] ?? '';
    $supplierId = (int) ($request['supplier'] ?? 0);
    $wareId = (int) ($request['store_id'] ?? 0);
    $mft_date = $request['mft_date'] ?? '';
    $expiry_date = $request['expiry_date'] ?? '';
    $category = $request['category'] ?? '';
    $today_date = date("Y-m-d");

    $costTotal = $cost * $qty;
    $saleTotal = $price * $qty;

    return $this->CreateProduct(
        $batch, $item, $item_desc, $cost, $profit, $price, $qty,
        $barcode, $supplierId, $wareId, $mft_date, $expiry_date,
        $category, $today_date, $costTotal, $saleTotal
    );
}



    public function updateProduct(array $request = [], array $file = [])
    {
        return $this->premium_notification();
    }

    public function getProducts()
    {
        $products = $this->getAllProducts();
        if ($products) {
            return $products;
        }
    }

    public function getProductSalesRecords($pid)
    {
        $products = $this->getProductSalesRecordsById($pid);
        if ($products) {
            return $products;
        }
    }

    public function get_product_by_barcode($barcode)
    {
        $code = $this->validate($barcode);
        if (!$this->isEmptyStr($code)) {
            return $this->fetch_product_by_barcode($code);
        } else {
            return '';
        }
    }

    public function updateSupplier(array $request): string
    {
        return $this->premium_notification();
    }

    public function addSupplier(array $request)
    {
        return $this->premium_notification();
    }



    public function getSuppliers()
    {
        $suppliers = $this->getAllSuppliers();
        if ($suppliers) {
            return $suppliers;
        }
    }

    public function getCountedProducts()
    {
        $response = $this->countProducts();

        if (!$this->isEmptyStr($response)) {
            echo (int) $response;
        }
    }

    public function countNewProducts()
    {
        return $this->countAllNewProducts();
    }

    public function currentYearRevenue()
    {
        return $this->totalCurrentYearRevenue();
    }

    public function countDailyInvoice()
    {
        return $this->countTodaySalesInvoice();
    }

    public function countDailyInvoiceByCashier($cashier)
    {
        return $this->countTodaySalesInvoiceByCashier($cashier);
    }

    public function countAllSalesInvoiceByCashier($cashier)
    {
        return $this->countTotalSalesInvoiceByCashier($cashier);
    }

    public function getCountedSuppliers()
    {
        $response = $this->countSuppliers();

        if (!$this->isEmptyStr($response)) {
            echo (int) $response;
        }
    }
    public function showSuppliersInDropDownList()
    {
        return $this->getAllSuppliersInDropDown();
    }

    public function showProductsInDropDownList()
    {
        return $this->getAllProductsInDropDown();
    }

    public function showProductsInDropDownListByStoreId($wareId)
    {
        return $this->getAllProductsInDropDownByStoreId($wareId);
    }

    public static function showMENow()
    {
        return self::showME();
    }

    public function fetchProductJson($proId)
    {

        return $this->fetchJsonProductById($proId);

    }

    public function filterProductsByKeyword($keyword, $storeId)
    {
        return $this->searchProductByKeywords($keyword, $storeId);
    }

    public function fetchSupplierJson($Id)
    {

        return $this->fetchJsonSupplierById($Id);

    }
    public function fetchWarehouseJson($storeId)
    {

        return $this->fetchJsonWarehouseById($storeId);

    }

    public function authenticated(): void
    {
        if (!$this->app_authenticate()) {
            $this->redirect("setup");
        }
    }

    public function update_warehouse_info(array $request)
    {
        return $this->premium_notification();
    }

    public function getKeyValuePairs($key1, $action_value)
    {
        $response = '<input type="hidden" name="' . $key1 . '" value="kme"><input type="hidden" name="action" value="' . $action_value . '">';
        echo $response;
    }

    public function CreateWahouse(array $request)
    {
        return $this->premium_notification();
    }

    protected function premium_notification(): string
    {
        return $this->toast("info", "This is a DEMO VERSION,  <a href='https://flaterptech.com/#linkAppPurchase' target='_blank' title='Click here' style='color:red;'> CLICK HERE NOW</a> to Purchase Full version!");
    }

    public function getWarehouses()
    {
        $stores = $this->getAllStores();
        if ($stores) {
            return $stores;
        }
    }

    public function getCountedWarehouses($status)
    {
        $response = $this->countStores($status);

        if (!$this->isEmptyStr($response)) {
            echo (int) $response;
        }
    }

    public function count_Warehouses()
    {
        $response = $this->count_store();

        if (!$this->isEmptyStr($response)) {
            echo (int) $response;
        }
    }

    public function showWarehousesInDropDownList()
    {
        return $this->getAllStoresInDropDown();
    }

    public function get_store_by_id($id)
    {
        return $this->findStoreById($id);
    }

    public function showAllExpiredProduct()
    {
        return $this->fetchAllExpiredInSevenDaysTimes();
    }

    public function CountExpired()
    {
        return $this->countExpiredProducts();
    }

    public function countExpiredInSevenDaysTime()
    {
        return $this->countExpiredProductsInSevenDaysTime();
    }

    public function countExpiredInThreeMonthTime()
    {
        return $this->countExpiredProductsInThreeMonthTime();
    }

    public function countExpiredInSixMonthTime()
    {
        return $this->countExpiredProductsInSixMonthTime();
    }

    public function countAllSalesInvoices()
    {
        return $this->getAllSalesInvoices();
    }

    public function CurrentMonthSalesrecord()
    {
        return $this->getCurrentMonthSalesrecord();
    }

    public function lastThreeMonthSalesrecord()
    {
        return $this->getLastThreeMonthSalesrecord();
    }

    public function subscription(): void
    {
        if ($this->expire()) {
            $this->redirect("renew");
        }
    }

    public function lastSixMonthSalesrecord()
    {
        return $this->getLastSixMonthSalesrecord();
    }

    public function countUsers()
    {
        return $this->countAllUsers();
    }

    public function searchSupplier($field, $value)
    {
        return $this->findSupplier($field, $value);
    }



    public function addCategory(array $request)
    {
        return $this->premium_notification();
    }

    public function updateCategory(array $request)
    {
        return $this->premium_notification();
    }

    public function getCategory()
    {
        $cats = $this->getAllCategory();
        if ($cats) {
            return $cats;
        }
    }

    public function getExpenses()
    {
        $exp = $this->getAllExpenses();
        if ($exp) {
            return $exp;
        }
    }

    public function fetchExpensesByStoreId($wareId)
    {
        $exp = $this->getAllExpensesByStoreId($wareId);
        if ($exp) {
            return $exp;
        }
    }

    public function showCategoriesInDropDownList()
    {
        return $this->getAllCategoriesInDropDown();
    }

    public function get_date($date)
    {
        return date("M jS, Y", strtotime($date));
    }

    public function get_time($date)
    {
        return date("h:i:s A", strtotime($date));
    }

    public function getInvoiceDetailsById($orderId)
    {
        return $this->getOrderDetailsById($orderId);
    }
    public function getTransferInvoiceDetailsById($Id)
    {
        return $this->getTransferDetailsById($Id);
    }

    public function fetchDeliveryReport($orderId)
    {
        return $this->getDeliveryReport($orderId);
    }

    public function getOrderItemsList($invoice_id)
    {
        return $this->getOrderItemsDetailsByOrderId($invoice_id);
    }

    public function getGoodsTransferedItemsList($invoice_id)
    {
        return $this->getTransferItemsDetailsByOrderId($invoice_id);
    }

    public function fetchOrderDetailsPerSalesPerson($salepseron)
    {
        return $this->getAllOrderDetailsPerSalesPerson($salepseron);
    }
    public function fetchOrderDetails()
    {
        return $this->getAllOrderDetails();
    }

    public function fetchAllTransferDetails()
    {
        return $this->getAllTransferDetails();
    }

    public function fetchAllTodaysTransactionsByCashier($cashier)
    {
        return $this->getAllTodaysTransactionsByCashier($cashier);
    }

    public function fetchAllSalessTransactionsByCashier($cashier)
    {
        return $this->getAllSalessTransactionsByCashier($cashier);
    }
    public function getmonthlySalesRecordByPaymentTypeByCashier($paidType, $cashier)
    {
        return $this->monthlySalesRecordByPaymentTypeByCashier($paidType, $cashier);
    }

    public function filterSalesReportsByDates($date_from, $date_to, $payment_type)
    {
        return $this->getSalesOrderReportsByDate($date_from, $date_to, $payment_type);
    }

    public function filterTransferReportsByDates($date_from, $date_to, $wareId)
    {
        return $this->getTransferOrderReportsByDate($date_from, $date_to, $wareId);
    }

    public function fetchSalesOrderReportsByDateByCashier($date_from, $date_to, $payment_type, $cashier)
    {
        return $this->getSalesOrderReportsByDateByCashier($date_from, $date_to, $payment_type, $cashier);
    }

    public function showTokenGenerated($len = 50)
    {
        return $this->generateToken($len);
    }
    /*Original Author: Flat ERP Technologies Nigeria +23481-3137-4443 */
    public function checkDuplicateLoggedIn($email, $token): bool
    {
        return $this->checkTokenExists($email, $token);
    }
    public function showLastSevenDaysTransaction()
    {
        return $this->getLastSevenDaysSales();
    }

    public function todaySales()
    {
        return $this->getTodaySales();
    }

    public function todaySalesByCashier($cashier)
    {
        return $this->fetchTodaySalesByCashier($cashier);
    }

    public function CurrentMonthSalesrecordByCashier($cashier)
    {
        return $this->getCurrentMonthSalesrecordByCashier($cashier);
    }

    //
    public function LastSevenDaysSalesByCashier($cashier)
    {
        return $this->getLastSevenDaysSalesByCashier($cashier);
    }

    public function CurrentYearRecordBySalesRep($cashier)
    {
        return $this->getCurrentYearRecordBySalesRep($cashier);
    }

    //
    public function AllMyTotalSalesByCashier($cashier)
    {
        return $this->getAllMyTotalSalesByCashier($cashier);
    }

    public function addNewUSer(array $request)
    {
        return $this->premium_notification();
    }

    public function fetchTodaysTransactions()
    {
        return $this->getAllTodaysTransactions();
    }

    public function fetchDeliveryReportList()
    {
        return $this->getDeliveryReportList();
    }

    public function getmonthlySalesRecordByPaymentType($paidType)
    {
        return $this->monthlySalesRecordByPaymentType($paidType);
    }


    public function getUserLocation($ip)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.geoplugin.net/json.gp?ip=" . $ip);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        print_r($result);
    }

    public function getUserIpAddress()
    {
        $ip = "";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        echo $ip;
    }

    public function thousand_format($number)
    {
        $number = (int) preg_replace('/[^0-9]/', '', $number);
        if ($number >= 1000) {
            $rn = round($number);
            $format_number = number_format($rn);
            $ar_nbr = explode(',', $format_number);
            $x_parts = array('K', 'M', 'B', 'T', 'Q');
            $x_count_parts = count($ar_nbr) - 1;
            $dn = $ar_nbr[0] . ((int) $ar_nbr[1][0] !== 0 ? '.' . $ar_nbr[1][0] : '');
            $dn .= $x_parts[$x_count_parts - 1];

            return $dn;
        }
        return $number;
    }

    protected function app_authenticate(): bool
    {
        if ($this->getAuthName() == "" && $this->getApplicationName() == "") {
            return false;
        } else {
            return $this->getAuthName() === $this->getApplicationName();
        }
    }

    public function deleteStore($id)
    {
        return $this->premium_notification();
    }

    public function deleteSupplier($id)
    {
        return $this->premium_notification();
    }

    public function deleteExpense($id)
    {
        return $this->premium_notification();
    }

    public function deleteCategory($id)
    {
        return $this->premium_notification();
    }

    public function deleteProduct($id)
    {
        return $this->premium_notification();
    }

    public function deleteOrdersById($orderId)
    {
        return $this->premium_notification();
    }

    public function deleteDeliveryReportById($reportId)
    {
        return $this->premium_notification();
    }

    private static function isAuthor(): bool
    {
        if (APP_AUTHOR <> self::MyStr() || APP_AUTHOR == "") {
            return false;
        } else {
            return true;
        }
    }

    public function import_products_via_csv(array $file): string
    {
        return $this->premium_notification();

    }


    public function registerApplicationStepOne(array $post, array $file): string
    {
        return $this->premium_notification();
    }

    public function admin_account_create(array $post): string
    {
        return $this->premium_notification();
    }

    public function showApplicationName(): void
    {
        echo $this->getApplicationName();
    }

    public function showApplicationDetails()
    {
        return $this->getApplicationDetails();
    }

    public function get_logo(): string
    {
        $logo = $this->showApplicationDetails()->logo;

        return APP_ROOT . "/assets/images/" . $logo;
    }

    public function import_products_via_csv_v2(array $file): string
    {
        return $this->premium_notification();

    }


    public function creditors($cashier): array
    {
        return $this->get_all_credit_sales_records($cashier);
    }

    public function show_creditors(): array
    {
        return $this->get_all_credit_sales();
    }

    public function currency(): void
    {
        echo APP_CURRENCY;
    }

    public function fetchUserById($fields, $value)
    {
        return $this->find($fields, $value);
    }

    public function updateUserProfile(array $post): string
    {
        return $this->premium_notification();
    }

    public function generate_delivery_report(array $post): string
    {
        return $this->premium_notification();
    }

    public function deleteUser($id): string
    {
        return $this->premium_notification();
    }

    public function no_record_found(int $colspan = 8): void
    {
        echo '<tr><td colspan="' . $colspan . '" class="text-center fw-bold text-danger">No Records Found!</td></tr>';
    }

    private function getAuthName(): string
    {
        $query = "SELECT * FROM `cms`";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $rows = $stmt->fetch();
            return $this->decrypt($rows->cms_name);
        } else {
            return "";
        }
    }

    public function getValidation(array $request): string
    {
        return $this->validate_activation_code((array) $request);
    }

    public function get_profile()
    {
        return $this->get_company_profile();
    }


    public function send_password_reset_link(array $post): string
    {
        return $this->premium_notification();
    }

    public function validateEmailToken(string $email, string $token): bool
    {
        return $this->emailTokenValidation((string) $email, (string) $token);
    }

    public function update_password_action(array $post): string
    {
        return $this->premium_notification();
    }

    public function getcountProductsByStoreId($store_id): int
    {
        return $this->countProductsByStoreId($store_id);
    }

    public function createDemoUserAccount(array $post): string
    {
        return $this->premium_notification();
    }
    public function addExpenses(array $post): string
    {
        return $this->premium_notification();
    }
    public function updateExpenses(array $post): string
    {
        return $this->premium_notification();
    }
    public function react_to_expenses(array $post): string
    {
        return $this->premium_notification();
    }

    public function getProductById($proId)
    {
        $query = "SELECT * FROM $this->table WHERE proId=:proId LIMIT 1;";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":proId", $proId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $response = $stmt->fetch();
            $stmt = null;
            return $response;
        } else {
            return false;
        }
    }


    public function getProfitByStoreId($wareId)
    {
        $query = "SELECT 
        sum(selling_price) as sales, sum(profit*qty) as gross_profit,
        wareId,proId
        FROM $this->table 
        WHERE wareId=:wareId;";

        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":wareId", $wareId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $response = $stmt->fetchAll();
            $stmt = null;
            return $response;
        } else {
            return false;
        }
    }

    public function getAllProfit()
    {
        $query = "SELECT 
        sum(salesTotal) as sales, sum(profit*qty) as gross_profit,
        wareId,proId
        FROM $this->table ORDER BY wareId DESC LIMIT 100;";
        $stmt = $this->connect()->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $response = $stmt->fetchAll();
            $stmt = null;
            return $response;
        } else {
            return false;
        }
    }

    public function getExpenditureByStoreId($wareId)
    {
        $query = "SELECT 
        sum(amount) as amt 
        FROM expenses
        WHERE warehouse_id=:wareId AND status='Approved'";
        $stmt = $this->connect()->prepare($query);
        $stmt->bindParam(":wareId", $wareId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $response = $stmt->fetch();
            $stmt = null;
            return $response;
        } else {
            return false;
        }
    }


    public function displayApplicationName()
    {
        return $this->getApplicationName();
    }

}