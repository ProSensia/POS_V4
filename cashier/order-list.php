<?php require_once "helper.php";?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once ("Includes/MetaTag.php");?>

    <title>::POS:: Sales Record List </title>
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
                                <h3 class="fw-bold mb-0">Sales Records</h3>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3 mb-3"> 
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
                                                <th>Discount</th>
                                                <th>Payable</th>
                                                <th>Paid</th>
                                                <th>Due</th>
                                                <th>Payment</th>
                                              
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                    $AllOrders = $Controller->fetchOrderDetailsPerSalesPerson($userData->username);
                                    if (count($AllOrders) > 0) {
                                        foreach ($AllOrders as $order) {?>
                                            <tr>
                                           <td><a data-id="<?php echo $order->orderId;?>" class="showReportInvoiceBtn" style="cursor: pointer;"><strong><?php echo $order->invoiceNo;?></strong></a></td>
                                    <td><?php echo $order->customer;?></td>
                                    <td><?php echo $order->phone;?> <br><?php echo $order->email;?></td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->total,2);?></td>
                                    <td><?php echo number_format($order->discount_percent,2);?></td>
                                    <td><?php $Controller->currency();?><?php echo number_format($order->discount_price,2);?></td>
                                     <td><?php $Controller->currency();?><?php echo number_format($order->paid,2);?></td>
                                      <td>
                                       <?php $Controller->currency();?><?php echo number_format($order->due,2);?>
                                        </td>
                                    <td><span class="badge bg-primary"><?php echo $order->paymentType;?></span> </td>
                                    
                                            </tr>
                                            <?php
                                    }
                                    }else{
                                       $Controller->no_record_found(9);
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
    </script>
     <script>
         $(document).ready(function(){
          
            $(".showReportInvoiceBtn").on("click", function(){
                 let reportId = $(this).data("id");
               let action_page ="print80mm?invid="+reportId+"&action=generate";
               setTimeout(()=>{
                     window.open(action_page,"_blank","top=10, left=100, width=700, height=650");
                  },100)
            })
         });
         ;</script>
</body>

</html> 