<?php 

require_once "helper.php";

 ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once ("Includes/MetaTag.php");?>

    <title>::POS:: Order List </title>
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
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">Orders List</h3>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3 mb-3"> 
                        <div class="col-md-12">
                            <div class="card"> 
                                <div class="card-body"> 
                                    <table  class="table table-hover align-middle mb-0" style="width: 100%;">  
                                        <thead>
                                      <tr>
                                     <th>Order Id</th>
                                    <th>Customer</th>
                                    <th>Phone/Email</th>
                                    <th>Total</th>
                                    <th>Discount (%)</th>
                                    <th>Payable</th>
                                    <th>Paid</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                     <th>Cashier</th>
                                      <th>Action</th>
                                       </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                    $AllOrders = $Controller->fetchOrderDetails();
                                    if ($AllOrders) {
                                        foreach ($AllOrders as $order) {?>
                                            <tr>
                                                <td><a data-id="<?php echo $order->orderId;?>" class="showReportInvoiceBtn" style="cursor: pointer;"><strong><?php echo $order->invoiceNo;?></strong></a></td>
                                    <td><?php echo $order->customer;?></td>
                                    <td><?php echo $order->phone;?> <br><?php echo $order->email;?></td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->total,2);?></td>
                                    <td><?php echo number_format($order->discount_percent,1);?>%</td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->discount_price,2);?></td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->paid,2);?></td>
                                    <td><span class="badge bg-primary"><?php echo $order->paymentType;?></span> </td>
                                    <td><span class="badge bg-success"><?php echo $order->status;?></span></td>
                                    <td><?php echo $order->cashier_name;?></td>
                                                <td><button type="button" data-action="delete_order_by_id" data-id="<?php echo $order->orderId;?>" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button></td>
                                            
                                            <?php
                                    }?>
                                    </tr>
                                    <?php
                                    }else{
                                       $Controller->no_record_found(11);
                                    }
                                     ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
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

        $(document).ready(function() {
             $(".deleterow").on("click", function() {
               let rowId = $(this).data("id"),action=$(this).data("action");
               if (confirm("Are you Sure, you want to delete this Order?")) {
                   $.post("../app/View",{orderId:rowId,action:action},function(res){
                  setTimeout(function(){
                    if (res) {
                var tablename = $(this).closest('table').DataTable();  
                    tablename
                    .row( $(this)
                    .parents('tr'))
                    .remove()
                    .draw();  
                    }
                $("#server-response").html(res);
            },500)
               });
               }
               return false;
            });
        })
    </script>
</body>

</html> 