<?php 
   require_once "helper.php";
   
    ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
   <head>
      <?php include_once ("Includes/MetaTag.php");?>
      <title>::POS:: Suppliers </title>
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
                        <h3 class="fw-bold mb-0">Suppliers Information</h3>
                        <div class="col-auto d-flex w-sm-100">
                           <button type="button" class="btn btn-primary btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#addSupplierModalForm"><i class="icofont-plus-circle me-2 fs-6"></i>Add Suppliers</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Row end  -->
               <div class="row clearfix g-3">
                  <div class="col-sm-12">
                     <div class="card mb-3">
                        <div class="card-body">
                           <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                              <thead>
                                 <tr>
                                    <th>S/N</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Regdate</th>
                                    <th>e-Mail</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                     <th>Action</th>
                                   
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php 
                                    $AllSupplierss = $Controller->getSuppliers();
                                    if ($AllSupplierss !="") {
                                        $cnt =0;
                                        foreach ($AllSupplierss as $supplier) {
                                            $cnt++;?>
                                 <tr>
                                    <td><strong><?php echo $cnt; ?></strong></td>
                                    <td><?php echo $supplier->fullname;?> </td>
                                    <td>
                                       <span class="fw-bold ms-1"><?php echo $supplier->company;?></span>
                                    </td>
                                    <td><?php echo date("D M jS Y",strtotime($supplier->created_at));?></td>
                                    <td><?php echo $supplier->email;?></td>
                                    <td><?php echo $supplier->phone;?></td>
                                    <td><?php echo $supplier->address;?></td>
                                    <td>
                                      <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary editSupplierBtn" data-id="<?php echo $supplier->id;?>" data-action="show_supplier_edit_form"><i class="icofont-edit text-success"></i>
                                        </button>
                                         <button type="button" data-action="delete_supplier" data-id="<?php echo $supplier->id;?>" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                       </div>
                                       </div>
                                        </td>
                                    </td>
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
               </div>
               <!-- Row End -->
            </div>
         </div>
         <!-- Modal Custom Settings-->
         <!-- Add Expence-->
         <div class="modal fade" id="addSupplierModalForm" tabindex="-1"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title  fw-bold" id="expaddLabel">Add Suppliers</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                     <div class="deadline-form">
                        <form id="addSuppplierForm" autocomplete="off">
                           <div class="row g-3 mb-3">
                              <div class="col-sm-12">
                                 <label for="name" class="form-label">Supplier Name</label>
                                 <input type="text" class="form-control form-control-lg" id="name" placeholder="Enter name..." name="name">
                              </div>
                              <div class="col-sm-12">
                                 <label for="taxtno" class="form-label">Company Name</label>
                                 <input type="text" class="form-control form-control-lg" id="taxtno" name="company" placeholder="Enter Company name...">
                              </div>
                           </div>
                           <div class="row g-3 mb-3">
                              <div class="col-sm-12">
                                 <label for="abc11" class="form-label">Supplier e-Mail</label>
                                 <input type="text" class="form-control form-control-lg" id="abc11" placeholder="Enter Company e-mail..." name="email">
                              </div>
                              <div class="col-sm-12">
                                 <label for="abc111" class="form-label">Supplier Phone</label>
                                 <input type="text" class="form-control form-control-lg" id="abc111" placeholder="Enter Company phone..." name="phone">
                              </div>
                           </div>
                           <div class="row g-3 mb-3">
                              <div class="col-sm-12">
                                 <label class="form-label">Supplier Address</label>
                                 <textarea class="form-control form-control-lg" rows="2" placeholder="Enter Company address..." name="address"></textarea>
                              </div>
                           </div>
                           <input type="hidden" name="kme_supplier" value="kme">
                           <input type="hidden" name="action" value="create_new_supplier">
                           <div class="modal-footer">
                              <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary loading btn-lg">Submit</button>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Edit Expence-->

          <!-- Edit Modal -->
      <div class="modal fade" id="EditSupplierModal" tabindex="-1"  aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title fw-bold">Update Supplier</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <div class="deadline-form">
                     <form id="EditSupplierForm">
                        <div class="row g-3 mb-3">
                            <input type="hidden" name="supplier_id" id="supplier_original_id">
                           <div class="col-md-12">
                              <label for="supplier_name" class="form-label">Supplier Name</label>
                              <input type="text" class="form-control form-control-lg" id="supplier_name" name="supplier_name">
                           </div>
                           <div class="col-md-12">
                              <label for="company" class="form-label">Company</label>
                              <input type="text" class="form-control form-control-lg" id="supplier_company" name="supplier_company">
                           </div>
                        </div>
                        <div class="row g-3 mb-3">
                           <div class="col-md-12">
                              <label for="email" class="form-label">Email</label>
                              <input type="text" class="form-control form-control-lg" id="supplier_email" name="supplier_email">
                           </div>
                           <div class="col-md-12">
                              <label for="product_qty" class="form-label">Phone</label>
                              <input type="text" class="form-control form-control-lg" id="supplier_phone" name="supplier_phone">
                           </div>
                            <div class="col-md-12">
                              <label for="product_qty" class="form-label">Address</label>
                              <textarea class="form-control" rows="2" id="supplier_address" name="supplier_address"></textarea>
                           </div>
                        </div>
                         <?php $Controller->getKeyValuePairs("kme_supplier","update_existing_supplier");?>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-primary btn-lg cms_loading">Update</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
         
      </div>
      </div>
      <!-- Jquery Core Js -->
      <?php include_once ("Includes/FooterGeneralScript.php");?>
      <!-- Jquery Page Js -->
      <script>
         // project data table
         $(document).ready(function() {
             $('#myProjectTable')
             .addClass( 'nowrap' )
             .dataTable( {
                 responsive: true,
                 columnDefs: [
                     { targets: [-1, -3], className: 'dt-body-right' }
                 ]
             });
       
          $(".deleterow").on("click", function() {
               let rowId = $(this).data("id"),action=$(this).data("action");
               if (confirm("Are you Sure, you want to delete this Supplier?")) {
                   $.post("../app/View",{supplierId:rowId,action:action},function(res){
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
             //
               $("#addSuppplierForm").on("submit",function(e){
         e.preventDefault();
         $(".loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">Loading...').attr("disabled", "disabled");
         $.post("../app/View",$(this).serialize(),function(data){
            setTimeout(function(){
                $(".loading").html("Submit").attr("disabled", false);
                $("#server-response").html(data);
            },1000)
         
         })
         });

               //save update action
               $("#EditSupplierForm").on("submit",function(e){
         e.preventDefault();
         $(".cms_loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">updating...').attr("disabled", "disabled");
         $.post("../app/View",$(this).serialize(),function(data){
            setTimeout(function(){
                $(".cms_loading").html("Update").attr("disabled", false);
                $("#server-response").html(data);
            },1000)
         
         })
         });

           $(".editSupplierBtn").on("click", function(){
      let supplier_id = $(this).data("id");
      let action = $(this).data("action");
   
            $.ajax({
               url:"../app/View",
               method:"POST",
               data:{action:action,supplier_id:supplier_id},
               dataType:"JSON",
               success(result){
                if (result) {
                 $("#supplier_original_id").val(result.id);
                     $("#supplier_name").val(result.fullname);
                     $("#supplier_company").val(result.company);
                     $("#supplier_phone").val(result.phone);
                     $("#supplier_email").val(result.email);
                     $("#supplier_address").val(result.address);
                     $("#EditSupplierModal").modal("show");
                } 
               },
               error(err){
                  console.error(err.responseText);
               }
            });
         })

         });
      </script>
      </body>
</html>