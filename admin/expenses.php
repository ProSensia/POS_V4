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
                                    <button type="button" onclick="window.location.assign('profitloss');" class="btn btn-primary btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i>Profit & Loss</button>
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
                                                <th>Item Purchased</th>
                                                <th>Purchased By</th> 
                                                <th>Date</th>
                                                <th>Seller's Name</th> 
                                                <th>Amount</th>
                                                <th>Branch Name</th>
                                                <th>Status</th>   
                                                <th>Actions</th>  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 

                                            $AllExpenses = $Controller->getExpenses();
                                            if ($AllExpenses !="") {
                                                $cnt =0;
                                                foreach ($AllExpenses as $expense) {
                                                    $warehouse = $Controller->get_store_by_id($expense->warehouse_id);
                                                    $cnt++;?>
                                            <tr>
                                                <td><strong><?php echo $cnt; ?></strong></td>

                                                <td><?php echo ucfirst($expense->item) ?></td>
                                                <td><?php echo $expense->purchase_by;?></td>
                                                <td><?php echo $Controller->get_date($expense->date);?></td>
                                                <td><?php echo $expense->orderFrom;?></td>
                                                <td><?php $Controller->currency();?><?php echo number_format($expense->amount,2);?></td>
                                                <td><?php echo $warehouse->store_name;?></td>
                                                <td><?php if ($expense->status =="Pending") {
                                                   echo '<span class="badge bg-warning text-white">Pending</span>';
                                                }elseif ($expense->status =="Rejected") {
                                                    echo '<span class="badge bg-danger text-white">Cancelled</span>';
                                                }else{
                                                     echo '<span class="badge bg-success text-white">Approved</span>';
                                                } ?></td>
                                                <td>
                                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                        <button type="button" class="btn btn-outline-secondary edit_cat_btn" data-id="<?php echo $expense->id;?>" data-status="<?php echo $expense->status;?>"><i class="icofont-edit text-success"></i></button>
                                                        <button type="button" data-action="delete_expenses_" data-id="<?php echo $expense->id;?>" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                       </div>
                                                    </div>
                                                </td>
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
                    </div><!-- Row End -->
                </div>
            </div>
            
            <!-- Modal Custom Settings-->

            <!-- Edit Expence-->
            <div class="modal fade" id="expeditModal" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  fw-bold" id="expeditLabel"> Response to Expenses Submitted</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                     <form id="updateExpenseFormModal">
                    <div class="modal-body">
                        <div class="deadline-form">
                           
                                <div class="row g-3 mb-3">
                                    <input type="hidden" name="old_exp_id" id="old_exp_id">
                                    <div class="col-sm-12">
                                        <label class="form-label">Status</label>
                                        <select class="form-select form-control form-control-lg" id="data_status" name="data_status">
                                        </select>
                                    </div>
                                </div>
                           
                        </div>
                         <?php $Controller->getKeyValuePairs("kme_expense","admin_react_to_expenses");?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Done</button>
                        <button type="submit" class="btn btn-primary kme_loading">Submit</button>
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
                     $("#server-response").html(res);
                  },500);
               });
               }
               return false;
            });

             $(".edit_cat_btn").on("click", function(){
                let ExpId = $(this).data('id'),status=$(this).data("status");
                $("#old_exp_id").val(ExpId);
                $("#data_status").html(`<option selected value="${status}">${status}</option>
                 <option selected value="Pending">Pending</option>
                <option value="Approved">Approve</option>
                 <option value="Rejected">Rejected</option>`);
                $("#expeditModal").modal("show");
            });

          
//updateExpenseFormModal
 $("#updateExpenseFormModal").on("submit",function(e){
        e.preventDefault();
        $(".kme_loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">wait...').attr("disabled", "disabled");
       $.post("../app/View",$(this).serialize(),function(data){
           setTimeout(function(){
               $(".kme_loading").html("Submit").attr("disabled", false);
               $("#server-response").html(data);
           },500)

       })
    });
        
        });
    </script>
</body>

</html>