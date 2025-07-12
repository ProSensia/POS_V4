<?php
require_once "core.php";
$Controller = new Controller();
//check server request
$request_method = $_SERVER['REQUEST_METHOD'];
//Handle post Request
if ($request_method == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] !== ""){
        switch($_POST['action']){
            case 'login_user':
                echo $Controller->loginUser($_POST);
                break;

                case 'create_new_product':
               echo $Controller->addProduct($_POST);
                 break;

                  case 'create_new_demo_admin_account_':
               echo $Controller->createDemoUserAccount($_POST);
                 break; 

                 case 'add_new_company_expenses_':
               echo $Controller->addExpenses($_POST);
                 break;
                   case 'admin_react_to_expenses':
               echo $Controller->react_to_expenses($_POST);
                 break; 

                 case 'update_expenses_data':
               echo $Controller->updateExpenses($_POST);
                 break;

                   case 'update_existing_product':
               echo $Controller->updateProduct($_POST,$_FILES);
                 break;

                   case 'update_existing_supplier':
               echo $Controller->updateSupplier($_POST);
                 break;

                  case 'activate_my_product_action':
               echo $Controller->getValidation($_POST);
                 break;   

                  case 'send_password_reset':
               echo $Controller->send_password_reset_link($_POST);
                 break; 

                 case 'update_password_now':
               echo $Controller->update_password_action($_POST);
                 break;

                   case 'create_company_account':
               echo $Controller->registerApplicationStepOne($_POST,$_FILES);
                 break;                   

                case 'create_admin_account_':
               echo $Controller->admin_account_create($_POST);
                 break;

                  case 'create_new_supplier':
                echo $Controller->addSupplier($_POST);
                 break;
                 //create_new_user
                  case 'create_new_user':
                echo $Controller->addNewUSer($_POST);
                 break;

                 case 'fetch_product_id':
                 echo $Controller->fetchProductJson($_POST['proId']); 
                 break;

                  case 'show_store_update_form':
                 echo $Controller->fetchWarehouseJson($_POST['storeId']); 
                 break; 

                  case 'update_warehouse_details':
                 echo $Controller->update_warehouse_info($_POST); 
                 break;

                 case 'create_new_warehouse':
                 echo $Controller->CreateWahouse($_POST);  
                 break;

                 case 'create_new_category':
                 echo $Controller->addCategory($_POST);  
                 break;

                  case 'update_category_detail':
                 echo $Controller->updateCategory($_POST);  
                 break;

                  case 'create_new_receipt':
                 echo $Controller->generateCustomerReceipt($_POST);  
                 break; 

                 case 'create_new_transfer_receipt':
                 echo $Controller->productTrsanfer($_POST);  
                 break;
                 
                  case 'editProduct_action':
                 echo $Controller->fetchProductJson($_POST['proId']);  
                 break; 

                  case 'show_supplier_edit_form':
                 echo $Controller->fetchSupplierJson($_POST['supplier_id']);  
                 break;

                  case 'delete_ware_house':
                 echo $Controller->deleteStore($_POST['store_id']);  
                 break;
                 
                  case 'delete_supplier':
                 echo $Controller->deleteSupplier($_POST['supplierId']);  
                 break; 

                 case 'delete_expenses_':
                 echo $Controller->deleteExpense($_POST['expId']);  
                 break;

                 case 'delete_order_by_id':
                 echo $Controller->deleteOrdersById($_POST['orderId']);  
                 break; 

                 case 'delete_delivery_report_by_id':
                 echo $Controller->deleteDeliveryReportById($_POST['reportId']);  
                 break;

                 case 'delete_product':
                 echo $Controller->deleteProduct($_POST['prodId']);  
                 break;

                 case 'delete_user':
                 echo $Controller->deleteUser($_POST['userId']);  
                 break;

                  case 'update_user_account':
                 echo $Controller->updateUserProfile($_POST);  
                 break; 

                  case 'submit_delivery_reports':
                 echo $Controller->generate_delivery_report($_POST);  
                 break;
                 
                  case 'delete_category':
                 echo $Controller->deleteCategory($_POST['catid']);  
                 break;

                  case 'import_product_action_via_csv':
                 echo $Controller->import_products_via_csv($_FILES);  
                 break;

                  case 'update_creditor_bill':
                 echo $Controller->submit_creditor_payment($_POST);  
                 break;
                 
                  case 'search_product_via_barcode':
                 $result = $Controller->get_product_by_barcode($_POST['barcode']); 
                 if ($result) {
                     echo "<tr>
                     <td>$result->barcode</td>
                     <td>$result->name</td>
                     <td>$result->category</td>
                     <td>$result->expiry_date</td>
                     <td>$result->selling_price</td>
                     <td>$result->qty</td>
                     </tr>";
                  } else{
                    echo "<tr>
                     <td colspan='6' class='text-center text-danger'>No Record Found, Please check and try again!</td>
                     </tr>";
                  }
                 break;

                default:
                break;
    }
}

}

//Handle get Request
if($request_method == 'GET') {
    if (isset($_GET['user-action']) && $_GET['user-action'] != "") {
        switch ($_GET['user-action']) {
            case 'logoutadmin':
               $result = $Controller->logOutAdmin($_SESSION['loggedIn_ID'],$_SESSION['loggedIn_email']);
              if ($result ==='logout') {
                  session_destroy();
                $Controller->redirect("");
              }
                break;
                 case 'logoutcashier':
               $result = $Controller->logOutCashier($_SESSION['loggedIn_ID'],$_SESSION['loggedIn_email']);
              if ($result ==='logout') {
                  session_destroy();
                $Controller->redirect("");
              }
                break;
            
            default:
                // code...
                break;
        }
    }
}

