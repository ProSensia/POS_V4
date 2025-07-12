<?php
require_once "helper.php";

?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
   <?php include_once("Includes/MetaTag.php"); ?>
   <title>::POS:: Stock </title>
   <!--    GENERAL SCRIPT-->
   <?php include_once("Includes/HeaderGeneralScript.php"); ?>
   <!-- sidebar -->
   <?php include_once("Includes/SideBar.php"); ?>
   <!-- main body area -->
   <div class="main px-lg-4 px-md-4">
      <!-- Body: Header -->
      <?php include_once("Includes/HeaderNavBar.php"); ?>
      <!-- Body: Body -->
      <div class="body d-flex py-3">
         <div class="container-xxl">
            <div class="row align-items-center">
               <div class="border-0 mb-4">
                  <div
                     class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                     <h3 class="fw-bold mb-0">Stock Inventory </h3>
                     <div class="col-auto d-flex w-sm-100">
                        <button type="button" class="btn btn-primary btn-set-task w-sm-100" data-bs-toggle="modal"
                           data-bs-target="#expadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Product</button>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Row end  -->
            <div class="row g-3 mb-3">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <div class="table-responsive">
                           <table id="myDataTable" class="table table-striped mb-0" style="width: 100%;">
                              <thead>
                                 <tr>
                                    <th>Image/Barcode</th>
                                    <th>Products Information</th>
                                    <th>Category</th>

                                    <th>Item Location(Store)</th>
                                    <th>Actions</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                 $AllProducts = $Controller->getProducts();
                                 if ($AllProducts != "") {
                                    foreach ($AllProducts as $product) {
                                       $supplier = $Controller->searchSupplier("id", $product->supId);
                                       $warehouse = $Controller->get_store_by_id($product->wareId); ?>
                                       <tr>
                                          <td>
                                             <div class="text-center">
                                                <img src="../assets/images/products/<?php if ($product->image == NULL || $product->image == "") {
                                                   echo 'no_image.png';
                                                } else {
                                                   echo $product->image;

                                                } ?>" width="100" height="100"><br>
                                                <strong><?php echo $product->barcode; ?></strong>
                                             </div>
                                          </td>
                                          <td>Name :
                                             <span><strong><?php echo htmlspecialchars_decode($product->name); ?></strong></span><br>
                                             Price : <span
                                                class="text-info"><strong><?php $Controller->currency(); ?><?php echo number_format($product->selling_price, 2) ?></strong></span>
                                             <br>
                                             Qty : <span
                                                class="text-info"><strong><?php echo $product->qty; ?></strong></span>
                                          </td>

                                          <td><?php echo ($product->category); ?></td>

                                          <td><?php if ($warehouse) {
                                             echo $warehouse->store_name;
                                          } else {
                                             echo '<span class="badge bg-danger">Not Available</span>';
                                          } ?></td>

                                          <td>
                                             <div class="btn-group" role="group" aria-label="Basic outlined example">

                                                <button type="button" title="Click to remove" data-action="delete_product"
                                                   data-id="<?php echo $product->proId; ?>"
                                                   class="btn btn-outline-secondary deleterow"><i
                                                      class="icofont-ui-delete text-danger"></i></button>
                                             </div>
                                          </td>
                                       </tr>
                                       <?php
                                    }
                                 } else {
                                    $Controller->no_record_found(5);
                                 }

                                 ?>
                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Modal Custom Settings-->
   </div>
   </div>
   <!-- Add Expence-->
   <div class="modal fade" id="expadd" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title fw-bold">Add Product</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="deadline-form">
                  <form id="AddProductForm" autocomplete="off">
                     <div class="row g-3 mb-2">
                        <div class="col-sm-6">
                           <label for="item" class="form-label">Product Name</label>
                           <input type="text" class="form-control form-control-lg" id="item" placeholder="Item Name..."
                              name="item">
                        </div>
                        <div class="col-sm-6">
                           <label for="item_desc" class="form-label">Product Description</label>
                           <input type="text" class="form-control form-control-lg" id="item_desc"
                              placeholder="Item Description..." name="item_desc">
                        </div>
                     </div>
                     <div class="row g-3 mb-2">
                        <div class="col-sm-4 col-md-4">
                           <label for="cost" class="form-label">Cost Price</label>
                           <input type="text" class="form-control form-control-lg" id="cost"
                              placeholder="e.g <?php $Controller->currency(); ?>2,000.00" name="cost">
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <label for="item_price" class="form-label">Selling Price</label>
                           <input type="text" class="form-control form-control-lg" id="item_price"
                              placeholder="e.g <?php $Controller->currency(); ?>2,500.00" name="item_price">
                        </div>
                        <div class="col-sm-4 col-md-4">
                           <label for="item_qty" class="form-label">Qty (Cartons)</label>
                           <input type="number" class="form-control form-control-lg" name="item_qty"
                              placeholder="e.g 100 qty">
                        </div>
                     </div>
                     <div class="row g-3 mb-3">
                        <div class="col-md-4">
                           <label for="supplier" class="form-label">Supplier By</label>
                           <select class="form-select form-control custom-select form-control-lg" name="supplier">
                              <option value="" selected>Choose...</option>
                              <?php echo $Controller->showSuppliersInDropDownList(); ?>
                           </select>
                        </div>
                        <div class="col-md-4">
                           <label for="category" class="form-label">Item Category</label>
                           <select class="form-select form-control custom-select form-control-lg" name="category">
                              <option value="" selected>Choose...</option>
                              <?php echo $Controller->showCategoriesInDropDownList(); ?>
                           </select>
                        </div>
                        <div class="col-md-4">
                           <label for="store_id" class="form-label">Warehouse/Store</label>
                           <select class="form-select form-control custom-select form-control-lg" name="store_id">
                              <option value="" selected>Choose...</option>
                              <?php echo $Controller->showWarehousesInDropDownList(); ?>
                           </select>
                        </div>
                     </div>
                     <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                           <label class="form-label">MFT Date</label>
                           <input type="date" name="mft_date" class="form-control form-control-lg">
                        </div>
                        <div class="col-sm-6">
                           <label class="form-label">Best Before (BB)</label>
                           <input type="date" name="expiry_date" class="form-control form-control-lg">
                        </div>
                     </div>
                     <?php $Controller->getKeyValuePairs("kme_product", "create_new_product"); ?>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary btn-lg loading">Submit</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>


   <!-- Import Product Modal -->
   <div class="modal fade" id="ImportModal_" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xs">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title fw-bold">Import Product</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="deadline-form">
                  <form id="ImportCSVFileModalForm" enctype="multipart/form-data">
                     <div class="row g-3 mb-3">
                        <div class="col-sm-12">
                           <label for="file_import" class="form-label">Select CSV File Only</label>
                           <input type="file" class="form-control form-control-lg" name="file_import" id="file_import"
                              required>
                        </div>
                        <?php $Controller->getKeyValuePairs("kme_product_", "import_product_action_via_csv"); ?>
                        <!-- <?php //$Controller->getKeyValuePairs("kme_product_","import_product_action_via_csv_version_2"); ?> -->
                     </div>
                     <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Dismiss</button>
                        <button type="submit" class="btn btn-primary loading_loading">Import Now</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- Import Product Modal -->
   <!-- Jquery Core Js -->
   <?php include_once("Includes/FooterGeneralScript.php"); ?>
   <script>
      $('#myDataTable')
         .addClass('nowrap')
         .dataTable({
            responsive: true,
            columnDefs: [
               { targets: [-1, -3], className: 'dt-body-right' }
            ]
         });

      $(document).ready(function () {

         $(".PrintPriceTagBtn").on("click", function () {
            setTimeout(() => {
               window.open("barcode", "_blank", "top=10, left=100, width=950, height=900");
            }, 100);
         })
         $(".deleterow").on("click", function () {
            let rowId = $(this).data("id"), action = $(this).data("action");
            if (confirm("Are you Sure, you want to delete this Product?")) {
               $.post("../app/View", { prodId: rowId, action: action }, function (res) {
                  setTimeout(function () {
                     if (res) {
                        var tablename = $(this).closest('table').DataTable();
                        tablename
                           .row($(this)
                              .parents('tr'))
                           .remove()
                           .draw();
                     }
                     $("#server-response").html(res);
                  }, 500)
               });
            }
            return false;
         });

         $("#AddProductForm").on("submit", function (e) {
            e.preventDefault();
            $(".loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">Loading...').attr("disabled", "disabled");

            const formData = $(this).serialize();

            $.post("../app/View", formData, function (data) {
               setTimeout(function () {
                  $(".loading").html("Submit").attr("disabled", false);
                  $("#server-response").html(data);

                  // ✅ Check for successful response (assumes "Yes" from PHP)
                  if (data.trim() === "Yes") {
                     // ✅ Hide Bootstrap modal
                     $("#expadd").modal("hide");

                     // ✅ Reset form fields
                     $("#AddProductForm")[0].reset();

                     // ✅ Reload product list
                     if (typeof loadProductList === "function") {
                        loadProductList(); // This must be defined elsewhere
                     }

                     // ✅ Optional: show toast or success message
                     // alert("Product added successfully!");
                  }
               }, 500);
            });
         });


         $("#ImportCSVFileModalForm").on("submit", function (e) {
            e.preventDefault();

            $.ajax({
               url: "../app/View",
               type: "POST",
               async: true,
               data: new FormData(this),
               contentType: false,
               cache: false,
               processData: false,
               beforeSend() {
                  $(".loading_loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">Importing...').attr("disabled", "disabled");
               },
               success: function (response) {
                  setTimeout(function () {
                     $(".loading_loading").html('Import Now').attr("disabled", false);
                     $("#server-response").html(response);
                  }, 1000);
               },
               error: function (msg) {
                  $("#server-response").html(msg);
               }
            });

         });
      })
   </script>
   </body>

</html>