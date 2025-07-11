<?php 
   require_once "helper.php";
   
    ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
   <head>
      <?php include_once ("Includes/MetaTag.php");?>
      <title>::POS:: Stock </title>
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
                        <h3 class="fw-bold mb-0">Search Stock Inventory</h3>
                        <div class="col-auto d-flex w-sm-100">
                           <button type="button" onclick="window.location.assign('./products');" class="btn btn-primary btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i>View Products</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Row end  -->
               <div class="row g-3 mb-3">
                  <div class="col-md-12">
                     <div class="card">
                        <form class="form-inline mt-3 m-2 row" id="SearchForm">
                           <div class="col-md-12 mb-3">
                              <input type="text" autocomplete="off" id="search" autofocus name="search" class="form-control form-control-lg" placeholder="Use barcode scanner to scan product">
                           </div>
                          <!--  <div class="col-md-4">
                              <button class="btn btn-dark btn-lg">Search</button>
                           </div> -->
                        </form>
                        <div class="card-body">
                           <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                              <thead>
                                 <tr>
                                    <th>Barcode</th>
                                    <th>Products</th>
                                    <th>Category</th>
                                    <th>Expires</th>
                                    <th>Price</th>
                                    <th>In Stock</th>
                                 </tr>
                              </thead>
                              <tbody id="table_data"></tbody>
                           </table>
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
      
      <!-- Jquery Core Js -->
      <?php include_once ("Includes/FooterGeneralScript.php");?>
      <script>
         $('#myDataTable')
         .addClass( 'nowrap' )
         .dataTable( {
             responsive: true,
             columnDefs: [
                 { targets: [-1, -3], className: 'dt-body-right' }
             ]
         });
      </script>

        <script>
         get_product_by_barcode();
  function get_product_by_barcode() {
    $("#search").on("change keyup", function(e) {
      e.preventDefault();
      let barcode = $(this).val();
      if (barcode !== "" || barcode != "") {
         $.ajax({
          url: "../app/View",
          type: "POST",
          data: {
            action: "search_product_via_barcode",
            barcode: barcode,
          },
          success: function(data) {
             console.log(data)
            if (data) {
               $('tbody').html(data);
            } else {
              $('tbody').html('');
            }
          }
        });
      } else {
         $('tbody').html('');
        return false;
      }
    })
  }
 
  $(document).ready(function() {
    $("#SearchForm").on("submit", function(e) {
      e.preventDefault();

    })
  })
  </script>
      </body>
</html>