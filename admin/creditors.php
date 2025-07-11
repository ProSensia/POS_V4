<?php 

require_once "helper.php";

 ?>
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
                                <h3 class="fw-bold mb-0">Credit Sales Records</h3>
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
                                                <th>Invoice No</th>
                                                <th>Customer Name</th>
                                                <th>Phone/Email</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Balance</th>
                                                <th>Cashier</th>
                                                <th>Date</th>
                                                <th>Pay Due</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                    $AllOrders = $Controller->show_creditors();
                                    if (count($AllOrders)> 0) {
                                        foreach ($AllOrders as $order) {?>
                                            <tr>
                                                <td><a data-id="<?php echo $order->orderId;?>" class="showReportInvoiceBtn" style="cursor: pointer;"><strong><?php echo $order->invoiceNo;?></strong></a></td>
                                                <td><span> <?php echo $order->customer;?> </span></td>
                                                <td><?php echo $order->phone;?> <br><?php echo $order->email;?></td>
                                                <td><?php $Controller->currency();?><?php echo $order->total;?></td>
                                                <td><?php $Controller->currency();?><?php echo $order->paid;?></td>
                                                <td>
                                                    <?php $Controller->currency();?><?php echo $order->due;?>
                                                </td>
                                                 <td>
                                                    <?php echo $order->cashier_name;?>
                                                </td>
                                                <td><?php echo date("Y-m-d",strtotime($order->trans_date));?></td>
                                                 <td><button type="button" class="btn btn-warning payDueBtn" data-id="<?php echo $order->orderId;?>" data-amount="<?php echo $order->due;?>" data-action="pay_due_bal_now">Pay Now</button></td>
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

    <!-- Add Expence-->
         <div class="modal fade" id="PayDueBalanceModalForm" tabindex="-1"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title  fw-bold" id="expaddLabel">Accept Due Balance</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                     <div class="deadline-form">
                        <form id="PayDueBalanceForm" autocomplete="off">
                           <div class="row g-3 mb-3">
                              <div class="col-sm-12">
                                <input type="hidden" name="paymentId" id="paymentId">
                                 <label for="due_bal" class="form-label">Total Due Balance</label>
                                 <input type="number" class="form-control" id="due_bal" name="due_balance" readonly required>
                              </div>
                              
                           </div>
                           <div class="row g-3 mb-3">
                              <div class="col-sm-12">
                                 <label class="form-label">Enter Payment Amount</label>
                                 <input type="number" class="form-control form-control-lg" placeholder="Enter amount paid" name="amount_paid">
                              </div>
                            
                           <input type="hidden" name="kme_user" value="kme">
                           <input type="hidden" name="action" value="update_creditor_bill">
                           <div class="modal-footer">
                              <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Dismiss</button>
                              <button type="submit" class="btn btn-primary kme_loading">SUBMIT</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Edit Expence-->

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
          
          $(".payDueBtn").on("click", function(){
            let due = parseFloat($(this).data("amount"));
            let paymentId = $(this).data("id");
            setTimeout(()=>{
                $("#due_bal").val(due);
                $("#paymentId").val(paymentId);
                $("#PayDueBalanceModalForm").modal("show");
            },200);
          });

          //when submit payment btn is clicked
          $("#PayDueBalanceForm").on("submit",function(e){
            e.preventDefault();
            $(".kme_loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">Loading...').attr("disabled", "disabled");
         $.post("../app/View",$(this).serialize(),function(data){
             setTimeout(function(){
              console.log(data)
                 $(".kme_loading").html("SUBMIT").attr("disabled", false);
                 $("#server-response").html(data);
             },500)
         });
          });
            $(".showReportInvoiceBtn").on("click", function(){
                 let reportId = $(this).data("id");
               let action_page ="print80mm?invid="+reportId+"&action=generate";
               setTimeout(()=>{
                     window.open(action_page,"_blank","top=10, left=100, width=700, height=950");
                  },100)
            })
         });
         ;</script>
</body>

</html> 