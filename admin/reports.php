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
                        <h3 class="fw-bold mb-0"><span class="icofont-chart-bar-graph fs-1 text-primary"></span> Sales Report for the Month of <strong class="text-primary"><?php echo date("F, Y");?></strong></h3>
                     </div>
                  </div>
               </div>
                <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
                  <div class="col">
                     <div class="alert-success alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-success text-light"><i class="fa fa-credit-card fa-lg" aria-hidden="true"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">Cash Payment</div>
                              <span class="small"><?php $Controller->currency();?><?php echo number_format($Controller->getmonthlySalesRecordByPaymentType("Cash"),2);?></span>
                             
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="alert-danger alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-danger text-light"><i class="fa fa-credit-card fa-lg"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">Transfer Payment</div>
                              <span class="small"><?php $Controller->currency();?><?php echo number_format($Controller->getmonthlySalesRecordByPaymentType("Transfer"),2);?></span>
                             
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="alert-warning alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="fa fa-credit-card fa-lg" aria-hidden="true"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">POS Payment</div>
                              <span class="small"><?php $Controller->currency();?><?php echo number_format($Controller->getmonthlySalesRecordByPaymentType("POS"),2);?></span>
                             
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="alert-info alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-info text-light"><i class="fa fa-credit-card fa-lg" aria-hidden="true"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0"> Cheque Payment</div>
                              <span class="small"><?php $Controller->currency();?><?php echo number_format($Controller->getmonthlySalesRecordByPaymentType("Cheque"),2);?></span>
                             
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Row end  -->
               <div class="row g-3 mb-3">
                  <div class="col-md-12">
                     <div class="card">
                        <div class="card-body">
                            <h3 class="text-muted mt-2 mb-2">You can filter sales record by date range</h3>
                           <div class="mb-3">
                              <form action="" class="row gy-2 gx-3 align-items-center" method="post">
                                 <div class="col-md-4">
                                    <div class="input-group">
                                       <div class="input-group-text">FROM</div>
                                       <input type="date" class="form-control form-control-lg" value="<?php echo date("Y-m-d",strtotime("-7 days"));?>" name="date_from" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="input-group">
                                       <div class="input-group-text">TO</div>
                                       <input type="date" class="form-control form-control-lg" name="date_to">
                                    </div>
                                 </div>
                                  <div class="col-md-2">
                                    <label class="visually-hidden" for="autoSizingSelect">Preference</label>
                                    <select class="form-select form-control form-control-lg form-select-lg" id="sale_type" name="sale_type">
                                        <option value="All" selected>All Payments</option>
                                       <option value="All" selected>All Payments</option>
                                       <option value="Cash" >Cash Only</option>
                                       <option value="POS">POS Only</option>
                                       <option value="Transfer">Transfer Only</option>
                                       <option value="Cheque">Cheque Only</option>
                                      
                                    </select>
                                 </div> 
                                 <div class="col-md-2">
                                    <button type="submit" class="btn btn-dark btn-md" name="search_sales_btn" value="get_report_by_date"><span class="icofont-search fs-4"></span> Search Record</button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>

                  <?php if (isset($_POST['search_sales_btn']) && $_POST['search_sales_btn'] === "get_report_by_date"): ?>
                     <?php 

                     $date_from = $Controller->validate($_POST['date_from']);
                     $date_to = $Controller->validate($_POST['date_to']);
                     if ($Controller->isEmptyStr($date_from) || $Controller->isEmptyStr($date_to)) {
                       echo $Controller->alert("danger","Please select Dates to filter reports");
                     }else{
                           $date_from = date("Y-m-d",strtotime($date_from));
                           $date_to = date("Y-m-d",strtotime($date_to));
                          $payment_type = $_POST['sale_type'] ?? "All";
                      $filterReports = $Controller->filterSalesReportsByDates($date_from,$date_to,$payment_type);

                        if ($filterReports) {?>
                            <div class="col-md-12">
                     <div class="card">
                        <div class="card-body">
                           <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                              <thead>
                                 <tr>
                                   
                                    <th>Order Id</th>
                                    <th>Customer</th>
                                    <th>Phone/Email</th>
                                    <th>Total</th>
                                    <th>Discount (%)</th>
                                    <th>Payable</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                     <th>Cashier</th>
                                     <th>Deliver Report</th>
                                 </tr>
                              </thead>
                              <tbody>

                                 <?php 
                                 foreach ($filterReports as $order) {?>
                                          <tr>
                                   <td><a data-id="<?php echo $order->orderId;?>" class="showReportInvoiceBtn" style="cursor: pointer;"><strong><?php echo $order->invoiceNo;?></strong></a></td>
                                    <td><?php echo $order->customer;?></td>
                                    <td><?php echo $order->phone;?> <br><?php echo $order->email;?></td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->total,2);?></td>
                                    <td><?php echo number_format($order->discount_percent,1);?>%</td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->discount_price,2);?></td>
                                    <td><span class="badge bg-primary"><?php echo $order->paymentType;?></span> </td>
                                    <td><span class="badge bg-success"><?php echo $order->status;?></span></td>
                                    <td><?php echo $order->cashier_name;?></td>
                                   <td><a href="delivery-report?invid=<?php echo $order->invoiceNo;?>">Delivery Report</a></td>
                                    
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
                            echo $Controller->alert("danger","No Record found!");
                        }

                     }
                      ?>
                     <?php else: ?>
                        <div class="col-md-12">
                     <div class="card">
                        <div class="card-body">
                           <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                              <thead>
                                 <tr>
                                    <th>Order Id</th>
                                    <th>Customer</th>
                                    <th>Phone/Email</th>
                                    <th>Total</th>
                                    <th>Discount (%)</th>
                                    <th>Payable</th>
                                    <th>Payment Method</th>
                                    <th>Status</th>
                                     <th>Cashier</th>
                                     <th>Deliver Report</th>

                                 </tr>
                              </thead>
                              <tbody>
                                 <?php 
                                    $AllOrders = $Controller->fetchOrderDetails();
                                    if ($AllOrders !="") {
                                        foreach ($AllOrders as $order) {?>
                                          <tr>
                                    <td><a data-id="<?php echo $order->orderId;?>" class="showReportInvoiceBtn" style="cursor: pointer;"><strong><?php echo $order->invoiceNo;?></strong></a></td>
                                    <td><?php echo $order->customer;?></td>
                                    <td><?php echo $order->phone;?> <br><?php echo $order->email;?></td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->total,2);?></td>
                                    <td><?php echo number_format($order->discount_percent,1);?>%</td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->discount_price,2);?></td>
                                    <td><span class="badge bg-primary"><?php echo $order->paymentType;?></span> </td>
                                    <td><span class="badge bg-success"><?php echo $order->status;?></span></td>
                                    <td><?php echo $order->cashier_name;?></td>
                                     <td><a href="delivery-report?invid=<?php echo $order->orderId;?>&action=d-report">Delivery Report</a></td>
                                 </tr>
                                     <?php
                                    }
                                    }
                                     ?>
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
         $('#myDataTable')
         .addClass( 'nowrap')
         .dataTable( {
             responsive: true,
             columnDefs: [
                 { targets: [-1, -3], className: 'dt-body-right' }
             ]
         });

      </script>

      <script>
         $(document).ready(function(){
          
            $(".showReportInvoiceBtn").on("click", function(){
                 let reportId = $(this).data("id");
               let action_page ="print80mm?invid="+reportId+"&action=generate";
               setTimeout(()=>{
                     window.open(action_page,"_blank","top=10, left=100, width=700, height=650");
                  },100)
            });
         });
         ;</script>
      </body>
</html>