<?php 
require_once '../app/vendor/autoload.php';
require_once "helper.php";
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
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
                        <h3 class="fw-bold mb-0">Print Product Tag</h3>
                        <div class="col-auto d-flex w-sm-100">
                           <button type="button" class="btn btn-primary btn-set-task w-sm-100"><i class="icofont-print me-2 fs-6"></i>Print</button>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Row end  -->
               <div class="row clearfix g-3">
                  <div class="col-sm-12">
                     <div class="card mb-3">
                        <div class="card-body">
                          <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .center {
  border: 5px solid;
  margin: auto;
  width: 100%;
  padding: 10px;
}

        .price-tags-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
            max-width: 8.2in; 
            margin: 20px auto;
            padding: 5px;
            box-sizing: border-box;
        }

        .price-tag {
            border: 2px solid #000000;
            padding: 5px;
            text-align: left;
        }

        .barcode {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="price-tags-container">
        <!-- Price Tag 1 -->
        <?php 
        $AllProducts = $Controller->getProducts();
          if ($AllProducts !="") {
             $cnt =0;
             foreach ($AllProducts as $product) {
             $cnt++;
              $warehouse = $Controller->get_store_by_id($product->wareId);?>
               <div class="price-tag" >
            <h5 style="line-height: 0;">
               <?php if ($warehouse) {
              echo strtoupper($warehouse->store_name);
               }?>
                  
               </h5>
            <div width="100%" style="display: flex; flex-wrap: nowrap;">
                <div style="width: 50%; margin-right: 5px; border-right: 1px solid black;">
                    <p style="line-height: 0; font-size: x-small;"><?php echo strtoupper( htmlspecialchars_decode($product->name)); ?></p>
                    <h4 style="line-height: 20px; padding: 3px; outline: 1px solid black;"><span>&#8358;</span><?php $Controller->currency();?><?php echo number_format($product->selling_price,2) ?></h4>
                </div>
                <div class="barcode" width="50%"><?php echo $generator->getBarcode($product->barcode, $generator::TYPE_CODE_128); ?> <br>#<?php echo rand(000,999).$cnt;?></div>
            </div>
        </div>
    <?php
                                    }
                                    }
?>

      
    </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Row End -->
            </div>
         </div>
        

        
         
      </div>
      </div>
      <!-- Jquery Core Js -->
      <?php include_once ("Includes/FooterGeneralScript.php");?>
      <!-- Jquery Page Js -->
      
      </body>
</html>