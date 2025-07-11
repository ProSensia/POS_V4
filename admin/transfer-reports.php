<?php 
   require_once "helper.php";
   
    ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
   <head>
      <?php include_once ("Includes/MetaTag.php");?>
      <title>::POS:: Order Reports </title>
      <!--    GENERAL SCRIPT-->
      <?php include_once ("Includes/HeaderGeneralScript.php");?>
      <!-- sidebar -->
      <?php include_once ("Includes/SideBar.php")?>
      <!-- main body area -->
      <div class="main px-lg-4 px-md-4">
         <!-- Body: Header -->
         <?php include_once ("Includes/HeaderNavBar.php")?>
         <!-- Body: Body -->
         <div class="body d-flex py-3">
            <div class="container-xxl">
               <div class="row align-items-center">
                  <div class="border-0 mb-4">
                     <!-- chart-histogram -->
                     <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0"><span class="icofont-chart-bar-graph fs-1 text-primary"></span>  Transfer Reports</strong></h3>
                     </div>
                  </div>
               </div>
                
               <!-- Row end  -->
               <div class="row g-3 mb-3">
                  <div class="col-md-12">
                     <div class="card">
                        <div class="card-body">
                            <h3 class="text-muted mt-2 mb-2">Filter Reports by date range</h3>
                           <div class="mb-3">
                              <form action="" class="row gy-2 gx-3 align-items-center" method="post">
                                 <div class="col-md-3">
                                    <div class="input-group">
                                       <div class="input-group-text">FROM DATE</div>
                                       <input type="date" class="form-control form-control-lg" value="<?php echo date("Y-m-d",strtotime("-7 days"));?>" name="date_from" >
                                    </div>
                                 </div>
                                 <div class="col-md-3">
                                    <div class="input-group">
                                       <div class="input-group-text">TO DATE</div>
                                       <input type="date" class="form-control form-control-lg" name="date_to">
                                    </div>
                                 </div>
                                  <div class="col-md-3">
                                    <label class="visually-hidden" for="autoSizingSelect">Destination Store</label>
                                    <select class="form-select form-control form-control-lg form-select-lg" id="store_id" name="store_id">
                                        <option value="" selected>Destination Store</option>
                                       <?php echo $Controller->showWarehousesInDropDownList();?>
                                    </select>
                                 </div> 
                                 <div class="col-md-3">
                                    <button type="submit" class="btn btn-dark btn-md" name="search_transfer_btn" value="get_transfer_report_by_date"><span class="icofont-search fs-5"></span> Search Record</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>

                  <?php if (isset($_POST['search_transfer_btn']) && $_POST['search_transfer_btn'] === "get_transfer_report_by_date"): ?>
                     <?php 

                     $date_from = $Controller->validate($_POST['date_from']);
                     $date_to = $Controller->validate($_POST['date_to']);
                     if ($Controller->isEmptyStr($date_from) || $Controller->isEmptyStr($date_to)) {
                       echo $Controller->alert("danger","Please select Dates to filter Transfer history");
                     }else{
                           $date_from = date("Y-m-d",strtotime($date_from));
                           $date_to = date("Y-m-d",strtotime($date_to));
                          $store_id = trim($_POST['store_id']) ?? "";
                      $filterReports = $Controller->filterTransferReportsByDates($date_from,$date_to,$store_id);?>

                            <div class="col-md-12">
                     <div class="card">
                        <div class="card-body">
                           <table class="table table-hover align-middle mb-0" style="width: 100%;">
                              <thead>
                                 <tr>
                                    <th>Transfer Id</th>
                                    <th>Authorised By</th>
                                    <th>Transfer From</th>
                                    <th>Transfer To</th>
                                    <th>Worth of Goods</th>
                                    <th>Note</th>
                                    <th>Received By</th>
                                     <th>Date</th>
                                     
                                 </tr>
                              </thead>
                              <tbody>
                                  <?php

                        if ($filterReports) {

                                 foreach ($filterReports as $order) {
                                     $store_from = $Controller->get_store_by_id($order->from_store);
                                          $store_to = $Controller->get_store_by_id($order->to_store);?>
                                          <tr>
                                   <td><a data-id="<?php echo $order->id;?>" class="showReportInvoiceBtn" style="cursor: pointer;"><strong><?php echo $order->trNo;?></strong></a></td>
                                    <td><?php echo $order->author;?></td>
                                    <td><?php echo $store_to->store_name;?> </td>
                                    <td><?php echo $store_from->store_name;?></td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->total,2);?></td>
                                    <td><?php echo $order->note;?></td>
                                    <td><?php echo $order->received_by;?></td>
                                    <td><?php echo date("Y-m-d",strtotime($order->created_at));?></td>
                                  
                                    
                                 </tr>
                                     <?php
                                    }
                                  
                                     ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                           <?php
                          
                        }else{
                            $Controller->no_record_found(8);
                        }

                     }
                      ?>
                     <?php else: ?>
                        <div class="col-md-12">
                     <div class="card">
                        <div class="card-body">
                           <table class="table table-hover align-middle mb-0" style="width: 100%;">
                              <thead>
                                 <tr>
                                    <th>Transfer Id</th>
                                    <th>Authorised By</th>
                                    <th>Transfer From</th>
                                    <th>Transfer To</th>
                                    <th>Worth of Goods</th>
                                    <th>Note</th>
                                    <th>Received By</th>
                                     <th>Date</th>
                                    
                                 </tr>
                              </thead>
                              <tbody>
<?php 
                                    $AllOrders = $Controller->fetchAllTransferDetails();
                                    if ($AllOrders) {
                                        foreach ($AllOrders as $order) {
                                          $store_from = $Controller->get_store_by_id($order->from_store);
                                          $store_to = $Controller->get_store_by_id($order->to_store);
                                           ?>
                                          <tr>
                                   <td><a data-id="<?php echo $order->id;?>" class="showReportInvoiceBtn" style="cursor: pointer;"><strong><?php echo $order->trNo;?></strong></a></td>
                                    <td><?php echo $order->author;?></td>
                                    <td><?php echo $store_to->store_name;?> </td>
                                    <td><?php echo $store_from->store_name;?></td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->total,2);?></td>
                                    <td><?php echo $order->note;?></td>
                                    <td><?php echo $order->received_by;?></td>
                                    <td><?php echo date("Y-m-d",strtotime($order->created_at));?></td>
                                   
                                    
                                 </tr>
                                     <?php
                                    }
                                 }
                                 else
                                 {
                                    $Controller->no_record_found(8);
                                 }?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <?php endif ?>
                  
               </div>
               <!-- Row end  -->
            </div>
         </div>
         <!-- Modal Custom Settings-->
      </div>
      </div> 
      <!-- Jquery Core Js -->
      <?php include_once ("Includes/FooterGeneralScript.php");?>
      <script>
         $(document).ready(function(){
          
            $(".showReportInvoiceBtn").on("click", function(){
                 let reportId = $(this).data("id");
               let action_page ="transfer-invoice80mm?trans-invid="+reportId+"&action=trans-report";
               setTimeout(()=>{
                     window.open(action_page,"_blank","top=10, left=100, width=700, height=650");
                  },100)
            })
         });
         ;</script>
      </body>
</html>