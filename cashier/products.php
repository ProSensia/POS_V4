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
                        <h3 class="fw-bold mb-0">Stock Inventory</h3>
                        <button type="button" class="btn btn-primary btn-set-task w-sm-100 me-2 m-1 PrintPriceTagBtn"><i class="icofont-print me-2 fs-6"></i>Generate Price Tag</button>
                        
                     </div>
                  </div>
               </div>
               <!-- Row end  -->
               <div class="row g-3 mb-3">
                  <p><a href="javascript:void(0);" onclick="history.back();" class="text-white m-2 btn btn-danger">Go Back</a></p>
                  <div class="col-md-12">
                     <div class="card">
                        <div class="card-body">
                           <table id="myDataTable" class="table table-hover align-middle mb-0" style="width: 100%;">
                              <thead>
                                 <tr>
                                    <th>Barcode</th>
                                    <th>Products</th>
                                    <th>Category</th>
                                    <th>Expire</th>
                                    <th>Price</th>
                                    <th>In Stock</th>
                                    <th>Status</th>
                                    <th>Price Tag</th>
                                   
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php 
                                    $AllProducts = $Controller->getAllProductsByStoreId($storeId);
                                    if ($AllProducts !="") {
                                        foreach ($AllProducts as $product) {
                                           $supplier = $Controller->searchSupplier("id",$product->supId);
                                            $warehouse = $Controller->get_store_by_id($product->wareId);
                                          ?>
                                 <tr>
                                    <td><div class="text-center">
                                       <img src="../assets/images/products/<?php if ($product->image == NULL || $product->image == "") {
                                       echo 'no_image.png';
                                    }else{
                                       echo $product->image;

                                    } ?>" width="100" height="100"><br> <strong><?php echo $product->barcode;?></strong> 
                                    </div></td>
                                    <td><span><?php echo htmlspecialchars_decode($product->name); ?></span> <br><i class="text-info"><?php echo htmlspecialchars_decode($product->prod_desc); ?></i> </td>
                                   
                                    <td><?php echo ($product->category); ?></td>
                                    <td><?php echo $Controller->get_date($product->expiry_date); ?></td>
                                    <td>&#8358;<?php echo number_format($product->selling_price,2) ?></td>
                                    <td>
                                       <?php echo ($product->qty);?>
                                    </td>
                                    <td> <?php if ($product->qty >=5 ){
                                       echo '<span class="badge bg-success">In Stock</span>';
                                    }elseif($product->qty >=1 && $product->qty <= 4){
                                         echo '<span class="badge bg-warning">Low Stock</span>';

                                    }else{
                                       echo ' <span class="badge bg-danger">Out of Stock</span>';
                                    }?>
                                    </td>
                                   <td><a href="printtag?proId=<?php echo $product->proId;?>&action=print-tag"><button type="button" class="btn btn-secondary btn-set-task w-sm-100 me-2 m-1"><i class="icofont-print me-2 fs-6"></i>Price Tag</button></a></td>
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
               </div>
            </div>
         </div>
         <!-- Modal Custom Settings-->
      </div>
      </div>
      
     
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
         
         $(document).ready(function(){
             $(".PrintPriceTagBtn").on("click",function(){
               setTimeout(()=>{
                     window.open("barcode","_blank","top=10, left=100, width=950, height=900");
                  },100);
            });

         })
      </script>
      </body>
</html>