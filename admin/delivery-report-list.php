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
                                <h3 class="fw-bold mb-0">Delivery Reports</h3>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row g-3 mb-3"> 
                        <div class="col-md-12">

                            <div class="card"> 
                                <h4 class="m-2">  <button type="button" onclick="window.history.back();" class="btn btn-danger text-white float-left">Go Back</button></h4>
                                <div class="card-body"> 
                                    <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">  
                                        <thead>
                                      <tr>
                                     <th>Delivery Id</th>
                                    <th>Customer</th>
                                    <th>Phone/Email</th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Note</th>
                                    <th>Signed</th>
                                    <th>Status</th>
                                     <th>Remove</th>
                                     <th>Print</th>
                                      </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                    $reports = $Controller->fetchDeliveryReportList();
                                    if ($reports !="") {
                                        foreach ($reports as $order) {?>
                                            <tr>
                                     <td><strong><?php echo strtoupper($order->note_number);?></strong></td>
                                    <td><?php echo $order->customer_name;?></td>
                                    <td><?php echo $order->customer_phone;?> <br><?php echo $order->customer_email;?></td>
                                    <td><?php echo $order->shipped_from;?></td>
                                    <td><?php echo $order->delivery_address;?></td>
                                    <td><?php echo $order->note;?></td>
                                    <td><?php echo $order->signed_by;?> </td>
                                    <td> <?php if ($order->status == '1'): ?>
                                    <span class="badge bg-success">Completed</span>
                                        <?php else: ?>
                                      <span class="badge bg-danger">Cancelled</span>
                                    <?php endif ?> </td>
                                                <td><button type="button" data-action="delete_delivery_report_by_id" data-id="<?php echo $order->id;?>" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button></td>
                                                <td> <a href="printreceipt?receiId=<?php echo $order->invoice_no;?>&oId=<?php echo $order->order_id;?>&action=drp"><button type="button" class="btn btn-secondary"><i class="fa fa-print text-info"></i></button></a></td>
                                            </tr>
                                            <?php
                                    }
                                    }else{
                                       $Controller->no_record_found(10);
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
               if (confirm("Are you Sure, you want to delete this Report?")) {
                   $.post("../app/View",{reportId:rowId,action:action},function(res){
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