<?php 
   require_once "helper.php";
   
    ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
   <head>
      <?php include_once ("Includes/MetaTag.php");?>
      <title>::POS:: Stores </title>
      <!--    GENERAL SCRIPT-->
      <?php include_once ("Includes/HeaderGeneralScript.php");?>
      <!-- sidebar -->
      <?php include_once ("Includes/SideBar.php");?>
      <!-- main body area -->
      <div class="main px-lg-4 px-md-4">
         <!-- Body: Header -->
         <?php include_once ("Includes/HeaderNavBar.php");?>
         <!-- Body: Body -->
         <div class="body d-flex py-3">
            <div class="container-xxl">
               <div class="row align-items-center">
                  <div class="border-0 mb-4">
                     <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">Stores</h3>
                     </div>
                  </div>
               </div>
              
         
               <div class="row g-3 mb-3">
                  <p><a href="javascript:void(0);" onclick="history.back();" class="text-white m-2 btn btn-danger">Go Back</a></p>
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-transparent border-bottom-0">
                           <h6 class="m-0 fw-bold">Stores Data</h6>
                           <div class="col-auto d-flex w-sm-100">
                              <button type="button" class="btn btn-primary btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#newStoreModal"><i class="icofont-plus-circle me-2 fs-6"></i>Add Store</button>
                           </div>
                        </div>
                        <div class="card-body">
                           <table class="table table-hover align-middle mb-0" style="width: 100%;">
                              <thead>
                                 <tr>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>No of Products</th>
                                    <th>Cost Value</th>
                                    <th>Sales Value</th>
                                    <th>Manager</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php 
                                    $AllWarehouses = $Controller->getWarehouses();
                                    if ($AllWarehouses !="") {
                                        foreach ($AllWarehouses as $warehouse) {
                                          ?>
                                 <tr>
                                    <td><?php echo $warehouse->store_name;?></td>
                                    <td><?php echo $warehouse->store_location;?></td>
                                    <td><?php echo $Controller->countProductsByStoreId($warehouse->id);?></td>
                                    <td><?php $Controller->currency();?><?php echo number_format($Controller->getStoreWorth("cost_price","qty",$warehouse->id),2);?></td>
                                     <td><?php $Controller->currency();?><?php echo number_format($Controller->getStoreWorth("selling_price","qty",$warehouse->id),2);?></td>
                                    <td><?php echo $warehouse->manager;?></td>
                                    <td><?php echo $warehouse->phone;?></td>
                                    <td><?php echo $warehouse->status == 'Open' ? '<span class="badge bg-success">Open</span>':'<span class="badge bg-danger">Closed</span>' ?> </td>
                                    <td> <div class="btn-group" role="group" aria-label="Basic outlined example">
                                           <button type="button" data-id="<?php echo $warehouse->id;?>" data-action="show_store_update_form" class="btn btn-primary btn-set-task w-sm-100 edit_store_btn"><i class="icofont-edit-alt me-2 fs-6"></i></button>
                                           <button type="button" onclick="location.assign('./view-store?wid=<?php echo $warehouse->id;?>&name=<?php echo $warehouse->store_name;?>');" class="btn btn-warning btn-set-task w-sm-100" title="View available products"><i class="icofont-ui-map text-white"></i></button>
                                          <button type="button" data-action="delete_ware_house" data-id="<?php echo $warehouse->id;?>" class="btn btn-danger deleterow"><i class="icofont-ui-delete text-white"></i></button>
                                       </div></td>
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
               </div>
               <!-- Row end  -->
            </div>
         </div>
         <!-- Modal Custom Settings-->
      </div>
      </div>
      <!-- Add Store-->
      <div class="modal fade" id="newStoreModal" tabindex="-1"  aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title  fw-bold" id="depaddLabel"> Add New Store </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <!-- <div class="text-center mb-2" id="response"></div> -->
                  <div class="deadline-form">
                     <form autocomplete="off" id="AddNewWarehouseForm">
                        <div class="mb-3">
                           <label for="name" class="form-label"> Name</label>
                           <input type="text" class="form-control" name="name">
                        </div>
                        <div class="row g-3 mb-3">
                           <div class="col-sm-12">
                              <label for="manager" class="form-label"> Manager</label>
                              <input type="text" class="form-control" id="manager" name="manager">
                           </div>
                           <div class="col-sm-12">
                              <label for="location" class="form-label"> Location</label>
                              <textarea class="form-control" id="location" name="location" cols="2"></textarea>
                           </div>
                           <div class="col-sm-6">
                              <label for="phone" class="form-label">Store Phone</label>
                              <input type="text" class="form-control" id="phone" name="phone">
                           </div>
                           <div class="col-sm-6">
                              <label for="status" class="form-label">Status</label>
                              <select class="form-control form-select-sm" id="status" name="status">
                                 <option>Choose...</option>
                                 <option value="Open">Open</option>
                                 <option value="Closed">Closed</option>
                              </select>
                           </div>
                           <?php $Controller->getKeyValuePairs("kme_store","create_new_warehouse");?>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Dismiss</button>
                           <button type="submit" class="btn btn-primary loading">Create</button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- UPDATE STORE -->

      <div class="modal fade" id="updateStoreModal" tabindex="-1"  aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title  fw-bold" id="depaddLabel"> Update Store </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                 
                  <div class="deadline-form">
                     <form autocomplete="off" id="updateWarehouseForm">
                        <div class="mb-3">
                           <input type="hidden" name="store_id" id="originalId">

                           <label for="old_name" class="form-label"> Name</label>
                           <input type="text" class="form-control" name="name" id="old_name">
                        </div>
                        <div class="row g-3 mb-3">
                           <div class="col-sm-12">
                              <label for="manager" class="form-label"> Manager</label>
                              <input type="text" class="form-control" name="manager" id="old_manager">
                           </div>
                           <div class="col-sm-12">
                              <label for="location" class="form-label"> Location</label>
                              <textarea class="form-control" name="location" id="old_location" cols="2"></textarea>
                           </div>
                           <div class="col-sm-6">
                              <label for="phone" class="form-label">Store Phone</label>
                              <input type="text" class="form-control" id="old_phone" name="phone">
                           </div>
                           <div class="col-sm-6">
                              <label for="status" class="form-label">Status</label>
                              <select class="form-control form-select-sm" id="status" name="status" required>
                                 <option value="" selected>Choose...</option>
                                 <option value="Open">Open</option>
                                 <option value="Closed">Closed</option>
                              </select>
                           </div>
                           <?php $Controller->getKeyValuePairs("kme_store_update","update_warehouse_details");?>
                        </div>
                        <div class="modal-footer">
                           <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                           <button type="submit" class="btn btn-success text-white ks_loading">Save Changes</button>
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
         $(document).ready(function(){
            $(".edit_store_btn").on("click", function(){
      let storeId = $(this).data("id");
      let action = $(this).data("action");
      
        let options = {"action":action,"storeId": storeId};
            $.ajax({
               url:"../app/View",
               method:"POST",
               data:options,
               dataType:"JSON",
               success(result){
                if (result) {
                 $("#originalId").val(result.id);
                     $("#old_name").val(result.store_name);
                     $("#old_manager").val(result.manager);
                     $("#old_phone").val(result.phone);
                     $("#old_location").val(result.store_location);
                     $("#updateStoreModal").modal("show");
                } 
               },
               error(err){
                  console.error(err.responseText);
               }
            });
         })


              $(".deleterow").on("click", function() {
               let rowId = $(this).data("id"),action=$(this).data("action");
               if (confirm("If your delete a store, all products associated with it will be deleted, Are you Sure?")) {
                   $.post("../app/View",{store_id:rowId,action:action},function(res){
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

         $("#AddNewWarehouseForm").on("submit",function(e){
         e.preventDefault();
         $(".loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">Loading...').attr("disabled", "disabled");
         $.post("../app/View",$(this).serialize(),function(data){
            setTimeout(function(){
                $(".loading").html("Create").attr("disabled", false);
                $("#server-response").html(data);
            },1500)
         
         })
         })


          $("#updateWarehouseForm").on("submit",function(e){
         e.preventDefault();
         $(".ks_loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">Loading...').attr("disabled", "disabled");
         $.post("../app/View",$(this).serialize(),function(response){
            setTimeout(function(){
                $(".ks_loading").html("Save Changes").attr("disabled", false);
                $("#server-response").html(response);
            },1500)
         
         })
         })
         });
      </script>
      </body>
</html>