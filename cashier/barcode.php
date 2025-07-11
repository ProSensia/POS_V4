<?php 
require_once '../app/vendor/autoload.php';
require_once "helper.php";
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Tag Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .price-tags-container {
            justify-content: center;
            justify-items: center;
            align-items: center;
            text-align: center;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 20px;
            max-width: 8.268in; 
            max-height: 10in; 
            
            padding: 5px;
            box-sizing: border-box;
        }

        .price-tag {
            border: 1px solid #000000;
            padding: 3px;
            text-align: left;
            max-width: 2.4in;
            max-height: 1.2in;
            overflow: hidden;
        }

        .barcode {
            max-width: 60%;
        }
    </style>
</head>
<body>
    <div class="price-tags-container">
        <!-- Price Tag 1 -->
        <?php 
        $AllProducts = $Controller->getAllProductsByStoreId($storeId);
          if ($AllProducts !="") {
             $cnt =0;
             foreach ($AllProducts as $product) {
             $cnt++;
              $warehouse = $Controller->get_store_by_id($product->wareId);?>
               <div class="price-tag" >
            <h6 style="line-height: 0; margin-top:5px; text-align: center;white-space:nowrap;">
                <?php if ($warehouse) {
              echo strtoupper($warehouse->store_name);
               }?>
                
               </h6>
            <div width="100%">
                <div style="width: 80%; margin: auto;">
                    <p style="line-height: 0; margin-top:-8px; font-size: x-small; white-space:nowrap; text-align: center;"><?php echo strtoupper( htmlspecialchars_decode($product->name)); ?></p>
                    <h5 style="line-height: 20px;  margin-top:0px; text-align: center;padding: 1px; outline: 1px solid black;"><span></span><?php $Controller->currency();?><?php echo number_format($product->selling_price,2) ?></h5>
                </div>
                <div class="barcode" style="width: 60%; margin-top:-15px;"><?php echo $generator->getBarcode($product->barcode, $generator::TYPE_CODE_128); ?> </div>
                <div style="margin-top:2px; text-align: center;font-size: x-small;"><?php echo "#". rand(000,999).$cnt;?></div>
            </div>
        </div>
    <?php
                                    }
                                    }
?>

      
    </div>

<script>
    onload = () => {
    print();
    }
</script>
</body>
</html>