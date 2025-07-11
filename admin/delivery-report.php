<?php 
   require_once "helper.php";
   if (isset($_GET['invid']) && $_GET['invid'] !== "" && isset($_GET['action']) && $_GET['action'] === "d-report") {
     $InvoiceId = $Controller->validate($_GET['invid']);
     $order_data = $Controller->getInvoiceDetailsById($InvoiceId);

   }else{
      echo '<script>
      window.location.assign("./reports");
      </script>';
   }
    ?>
    <!doctype html>
<html class="no-js" lang="en" dir="ltr">
   <head>
      <?php include_once ("Includes/MetaTag.php");?>
      <title>::POS:: Delivery Report </title>
      <!--    GENERAL SCRIPT-->
      <?php include_once ("Includes/HeaderGeneralScript.php");?>
      <!-- sidebar -->
      <?php include_once ("Includes/SideBar.php");?>
      <!-- main body area -->
      <div class="main px-lg-4 px-md-4">
         <!-- Body: Header -->
         <?php include_once ("Includes/HeaderNavBar.php");?>
         <!-- Body: Body -->
         <div class="body d-flex py-lg-3 py-md-2">
            <div class="container-xxl">
               <div class="col-md-12 offset-0">
                  <div class="row">
                     <div class="col-sm-12 col-md-12">
                        <div class="card">
                           <div class="card-header">
                              <h3 class="text-center text-info">DELIVERY REPORT FOR TRANSACTION ID <?php echo $order_data->invoiceNo;?></h3>
                           </div>
                           <div class="card-body">
                              <form id="deliveryReportForm" autocomplete="off">
                           <div class="row mt-2">
                              <div class="col-md-6 mb-3">
                                 <input type="hidden" name="oid" value="<?php echo $order_data->orderId;?>">
                                 <input type="hidden" name="invNo" value="<?php echo  $order_data->invoiceNo;?>">
                                  <input type="hidden" name="store_id" value="<?php echo  $order_data->store_id;?>">
                                 <div class="form-group">
                                    <label>Customer Name:</label>
                                    <input type="text" name="customer_name" class="form-control form-control-lg" placeholder="Customer name..." value="<?php echo  $order_data->customer; ?>">
                                 </div>
                              </div>
                               <div class="col-md-6 mb-3">
                                
                                 <div class="form-group">
                                    <label>Customer Email:</label>
                                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Customer email" value="<?php echo $order_data->email;?>">
                                 </div>
                              </div>
                               <div class="col-md-6 mb-3">
                              
                                 <div class="form-group">
                                    <label>Customer Phone:</label>
                                    <input type="text" name="phone" class="form-control form-control-lg" placeholder="Customer Phone" value="<?php echo  $order_data->phone;?>">
                                 </div>
                              </div>
                               <div class="col-md-6 mb-3">
                                 <div class="form-group">
                                    <label>Delivery Note Number:</label>
                                    <input type="text" name="deliNo" class="form-control form-control-lg" placeholder="Delivery No..." value="<?php echo uniqid();?>">
                                 </div>
                              </div>
                               
                            
                              <div class="col-md-6 mb-3">
                                 <div class="form-group">
                                    <label>Shipped From:</label>
                                   <select class="form-select form-control form-control-lg" name="from">
                                   <?php  $warehouse = $Controller->get_store_by_id($order_data->store_id) ?>
                                    <option value="<?php echo $warehouse->store_name;?>" selected><?php echo $warehouse->store_name;?></option>
                                    <?php echo $Controller->showWarehousesInDropDownList();?>
                                 </select>
                                 </div>
                              </div>
                               <div class="col-md-6 mb-3">
                                 <div class="form-group">
                                    <label>Delivered To:</label>
                                    <input type="text" name="delivery_address" class="form-control form-control-lg" placeholder="Enter delivery address...">
                                 </div>
                              </div>
                                <div class="col-md-6 mb-3">
                                 <div class="form-group">
                                    <label>Delivery Note:</label>
                                    <textarea  name="note" class="form-control form-control-lg" placeholder="Enter delivery note here..."></textarea>
                                 </div>
                              </div>
                              <div class="col-md-3 mb-3">
                                 <div class="form-group">
                                    <label>Delivery Status:</label>
                                   <select class="form-select form-control form-control-lg" name="delivery_status">
                                   
                                    <option value="" selected>Choose...</option>
                                    <option value="1">Delivered</option>
                                    <option value="0">Cancelled</option>
                                 </select>
                                 </div>
                              </div>
                              <div class="col-md-3 mb-3">
                                 <div class="form-group">
                                    <label>Authorized:</label>
                                   <input type="text" name="signature" class="form-control" placeholder="enter signature">
                                 </div>
                              </div>
                              
                           </div>
                                 <?php $Controller->getKeyValuePairs("kme_delivery_report","submit_delivery_reports");?>
                                 <button type="button" onclick="window.history.back();" class="btn btn-danger text-white float-left">Go Back</button>
                                 <button type="submit" class="btn btn-primary btn-lg loading float-end">Generate</button>

                        </form>
                           </div>
                        </div>
                        
                     </div>
                  </div>
               </div>
            </div>
            <!-- Modal Custom Settings-->
     
 
         </div>
      </div>
      </div>
      <!-- Jquery Core Js -->
      <?php include_once ("Includes/FooterGeneralScript.php");?>
      <script>
       //
       $(document).ready(function(){
         $("#deliveryReportForm").on("submit",function(e){
         e.preventDefault();
         $(".loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">Loading...').attr("disabled", "disabled");
         const formData = $(this).serialize();
         $.post("../app/View",formData,function(data){
            setTimeout(function(){
                $(".loading").html("Submit").attr("disabled", false);
                $("#server-response").html(data);
            },1500)
         
         })
         })
       });
      </script>
      </body>
</html>