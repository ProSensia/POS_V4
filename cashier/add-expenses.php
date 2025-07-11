<?php 

require_once "helper.php";

 ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once ("Includes/MetaTag.php");?>

    <title>::POS:: Expenses </title>
    <!--    GENERAL SCRIPT-->
    <?php include_once ("Includes/HeaderGeneralScript.php");?>
    <!-- sidebar -->
    <?php include_once ("Includes/SideBar.php")?>
    <!-- main body area -->
    <div class="main px-lg-4 px-md-4">
        <!-- Body: Header -->
        <?php include_once ("Includes/HeaderNavBar.php")?>

            <!-- Body: Body -->       
            <div class="body d-flex py-lg-3 py-md-2">
                <div class="container-xxl">
                    <div class="row align-items-center">
                        <div class="border-0 mb-4">
                            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                                <h3 class="fw-bold mb-0">EXPENSES</h3>
                                <div class="col-auto d-flex w-sm-100">
                                    <button type="button" class="btn btn-primary btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#expadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Expenses</button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row clearfix g-3">
                        <div class="col-sm-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <table class="table table-hover align-middle mb-0" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Item</th>
                                                <th>Order By</th> 
                                                <th>Date</th>
                                                <th>Purchase From</th> 
                                                <th>Amount</th>
                                                <th>Status</th>   
                                                <th>Actions</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 

                                            $AllExpenses = $Controller->getAllExpensesByStoreId($storeId);
                                            if ($AllExpenses) {
                                                $cnt =0;
                                                foreach ($AllExpenses as $expense) {
                                                    //getExpenditureByStoreId
                                                    $cnt++;?>
                                            <tr>
                                                <td><strong><?php echo $cnt; ?></strong></td>

                                                <td><?php echo ucfirst($expense->item) ?></td>
                                                <td><?php echo $expense->purchase_by;?></td>
                                                <td><?php echo $Controller->get_date($expense->date);?></td>
                                                <td><?php echo $expense->orderFrom;?></td>
                                                <td><?php $Controller->currency();?><?php  echo number_format($expense->amount,2);?></td>
                                                <td><?php if ($expense->status =="Pending") {
                                                   echo '<span class="badge bg-warning text-white">Pending</span>';
                                                }elseif ($expense->status =="Rejected") {
                                                    echo '<span class="badge bg-danger text-white">Cancelled</span>';
                                                }else{
                                                     echo '<span class="badge bg-success text-white">Approved</span>';
                                                } ?></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button type="button" class="btn btn-outline-secondary edit_cat_btn" data-id="<?php echo $expense->id;?>" data-name="<?php echo $expense->item;?>" data-amount="<?php echo $expense->amount;?>" data-company="<?php echo $expense->orderFrom;?>" data-buyer="<?php echo $expense->purchase_by;?>" data-date="<?php echo $expense->date;?>" data-status="<?php echo $expense->status;?>"><i class="icofont-edit text-success"></i></button>
                                                        <!-- <button type="button" data-action="delete_expenses_" data-id="<?php //echo $expense->id;?>" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button> -->
                                       </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            }else{
                                             $Controller->no_record_found(8);
                                            }
                                             ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row End -->
                </div>
            </div>
            
            <!-- Modal Custom Settings-->

            <!-- Add Expence-->
            <div class="modal fade" id="expadd" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold" id="expaddLabel"> Add <strong class="text-info"><?php echo $warehouse_data->store_name?></strong> Expenses</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="deadline-form">
                            <form id="comapnyExpenseForm" autocomplete="off">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-12">
                                        <label for="item" class="form-label">Item Purchased</label>
                                        <input type="text" class="form-control form-control-lg" id="item" name="item_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="amount" class="form-label">Item Amount</label>
                                        <input type="text" name="amount" class="form-control form-control-lg" id="amount">
                                    </div>
                                     <div class="col-md-6">
                                    <label for="orderBy" class="form-label">Purchased By</label>
                                    <input type="text" class="form-control form-control-lg" name="orderBy" value="<?php echo ($userData->full_name);?>" readonly>
                                </div>
                                 <div class="col-md-6">
                                    <label for="date" class="form-label">This Date</label>
                                    <input type="date" class="form-control form-control-lg w-100" name="date">
                                </div>
                                 <div class="col-sm-6">
                                        <label for="purchaseFrom" class="form-label">Purchase From (Seller)</label>
                                        <input type="text" class="form-control form-control-lg" name="purchaseFrom">
                                    </div>
                                    <input type="hidden" name="wareId" value="<?php echo $storeId;?>">
                                </div>
                               
                              
                        </div>
                        
                    </div>
                     <?php $Controller->getKeyValuePairs("kme_expense","add_new_company_expenses_");?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary loading">Submit</button>
                    </div>
                     </form>
                </div>
                </div>
            </div>

            <!-- Edit Expence-->
            <div class="modal fade" id="expeditModal" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  fw-bold" id="expeditLabel"> Update Expenses Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                     <form id="updateExpenseFormModal">
                    <div class="modal-body">
                        <div class="deadline-form">
                           
                                <div class="row g-3 mb-3">
                                    <input type="hidden" name="old_exp_id" id="old_exp_id">
                                    <div class="col-sm-6">
                                        <label for="old_item_name" class="form-label">Item Desc</label>
                                        <input type="text" class="form-control form-control-lg" id="old_item_name" name="old_item_name">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="old_amount" class="form-label">Amount</label>
                                        <input type="text" class="form-control form-control-lg" id="old_amount" name="old_amount">
                                    </div>
                                </div>
                                <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label  class="form-label">Exp Order By</label>
                                   <input type="text" name="old_orderBy" id="orderBy" class="form-control form-control-lg">
                                </div>
                                <div class="col-sm-6">
                                    <label for="old_date" class="form-label">Date</label>
                                    <input type="date" class="form-control form-control-lg w-100" id="old_date" name="old_date">
                                </div>
                                </div>
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <label for="deptwo1" class="form-label">From</label>
                                        <input type="text" class="form-control form-control-lg" id="office_name" name="office_name">
                                    </div>
                                   
                                </div>
                           
                        </div>
                         <?php $Controller->getKeyValuePairs("kme_expense","update_expenses_data");?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                        <button type="submit" class="btn btn-primary kme_loading">Save Changes</button>
                    </div>
                     </form>
                </div>
                </div>
            </div>

        </div>
             
    </div>
    
    <!-- Jquery Core Js -->
    <?php include_once ("Includes/FooterGeneralScript.php");?>
    <script>
        // project data table
        $(document).ready(function() {
            $(".deleterow").on("click", function() {
               let rowId = $(this).data("id"),action=$(this).data("action");
               if (confirm("Are you Sure, you want to delete this Expenses?")) {
                   $.post("../app/View",{expId:rowId,action:action},function(res){
                  setTimeout(function(){
                $("#server-response").html(res);},500);
               });
               }
               return false;
            });

             $(".edit_cat_btn").on("click", function(){
                let ExpId = $(this).data('id'),itemName = $(this).data("name"),amount=$(this).data("amount")
                ,buyer=$(this).data("buyer"),company=$(this).data("company"),date=$(this).data("date"),status=$(this).data("status");
                $("#old_item_name").val(itemName);
                $("#orderBy").val(buyer);
                $("#old_amount").val(amount);
                $("#office_name").val(company);
                $("#old_date").val(date);
                $("#old_exp_id").val(ExpId);
                $("#expeditModal").modal("show");
            });

         $("#comapnyExpenseForm").on("submit",function(e){
         e.preventDefault();
         $(".loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">Pls wait...').attr("disabled", "disabled");
         $.post("../app/View",$(this).serialize(),function(data){
            setTimeout(function(){
                $(".loading").html("Submit").attr("disabled", false);
                $("#server-response").html(data);
            },500)
         
         })
         });

           
//updateExpenseFormModal
 $("#updateExpenseFormModal").on("submit",function(e){
        e.preventDefault();
        $(".kme_loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">wait...').attr("disabled", "disabled");
       $.post("../app/View",$(this).serialize(),function(data){
           setTimeout(function(){
               $(".kme_loading").html("Save Changes").attr("disabled", false);
               $("#server-response").html(data);
           },500)

       })
    });
        
        });
    </script>
</body>

</html>