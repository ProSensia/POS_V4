<?php 
require_once '../app/vendor/autoload.php';
require_once "helper.php";
$generator = new Picqer\Barcode\BarcodeGeneratorHTML();

if (isset($_GET['proId']) && $_GET['proId'] !== "" && isset($_GET['action']) && $_GET['action'] === "print-tag") {
      $proId = $Controller->validate($_GET['proId']);
      $product = $Controller->getProductById($proId);
      $warehouse = $Controller->get_store_by_id($product->wareId);
   }else{
      echo '<script>window.location.assign("./products")</script>';
      exit();
   }
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
                <div class="barcode" width="50%" height="40%"><?php echo $generator->getBarcode($product->barcode, $generator::TYPE_CODE_128); ?> <br>#<?php echo rand(0000000,99999999);?></div>
            </div>
        </div>
    

      
    </div>

<script>
	window.onload =()=>{
		window.print();
	}
</script>
</body>
</html>
