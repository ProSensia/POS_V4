<?php 
   require_once "helper.php";
   if (isset($_GET['receiId']) && $_GET['receiId'] !== "" && isset($_GET['oId']) && $_GET['oId'] !== "" && isset($_GET['action']) && $_GET['action'] === "drp") {
     $InvoiceNo = $Controller->validate($_GET['receiId']);
     $oId = $Controller->validate($_GET['oId']);
     $order_data = $Controller->getInvoiceDetailsById($oId);
     $delivery_report = $Controller->fetchDeliveryReport($InvoiceNo);

   }else{
      echo '<script>
      window.location.assign("./");
      </script>';
   }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>::POS:: Delivery Report </title>
  <?php include_once "Includes/MetaTag.php";?>
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <!------ Include the above in your HEAD tag ---------->
  <link rel="stylesheet" href="./receipt3.css">
  <style>
      .qr-code{
          opacity: 0;
          display: flex;
          padding: 33px 0;
          border-radius: 5px;
          align-items: center;
          pointer-events: none;
          justify-content: center;
          border: 1px solid #ccc;
      }
  </style>
</head>
<body >
  <!-- onload="window.print();" -->


<div class="container">
  <div class="row">
    
    <div class="receipt-main col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
      <div class="row">
        <div class="receipt-header">
          <div class="col-xs-6 col-sm-6 col-md-6">
           
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 text-right">
            <div class="receipt-right">
              <h5>FROM:</h5>
              <h5><?php echo strtoupper($cProfile->company);?></h5>
              <p><i class="fa fa-phone"></i><?php echo ($cProfile->phone);?></p>
              <p> <i class="fa fa-envelope-o"></i><?php echo ($cProfile->email);?></p>
              <p> <i class="fa fa-location-arrow"></i><?php echo ucwords($cProfile->address);?></p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="receipt-header receipt-header-mid">
          <div class="col-xs-7 col-sm-7 col-md-7 text-left">
            <div class="receipt-right">
              <h5>Date of Delivery:  <?php echo date("Y-m-d",strtotime($delivery_report->created_at)); ?></h5>
              <h5>Delivered To:</h5>
              <h5>Name: <?php echo $delivery_report->customer_name; ?></h5>
              <p><b>Phone :</b><?php echo $delivery_report->customer_phone; ?> </p>
              <p><b>Email :</b><?php echo $delivery_report->customer_email; ?> </p>
              <p><b>Delivery Address :</b> <?php echo $delivery_report->delivery_address; ?> </p>
            </div>
          </div>
          <div class="col-xs-5 col-sm-5 col-md-5">
            <div class="receipt-left">
                <h1 class="text-danger">Delivery Note</h1>
            </div>
          </div>
        </div>
      </div>
      
      <div>
        <table class="table table-bordered table-striped">
          <thead>
         <tr>
           <th class="text-center">S/N</th>
           <th class="text-center">Item</th>
           <th class="text-end">Unit Price</th>
           <th class="text-center">Qty</th>
           <th class="text-end">Total</th>
        </tr>
          </thead>
          <tbody>

<?php 
    $orderLists = $Controller->getOrderItemsList($order_data->orderId);

    if ($orderLists) {
       $cnt =0;
       foreach ($orderLists as $item) {
          $cnt++;
          ?>
           <tr>
       <td class="text-center"><?php echo $cnt; ?></td>
       <td class="text-center"><?php echo $item->product;?></td>
       <td class="text-end">&#8358;<?php echo number_format($item->price,2);?></td>
       <td class="text-center"><?php echo $item->qty;?></td>
       <td class="text-end">&#8358;<?php echo number_format($item->subtotal,2);?></td>
    </tr>
          <?php
       }
    }
     ?>
          <tr>
            <td class="text-right" colspan="4"><h5><strong>Total: </strong></h5></td>
            
            <td class="text-right text-danger"><h5><strong><i class="fa fa-inr"></i>&#8358;<?php echo number_format($order_data->total,2); ?> </strong></h5></td>
          </tr>
          <tr>
            <td class="text-right" colspan="4"><h5><strong>Paid: </strong></h5></td>
            
            <td class="text-right text-danger"><h5><strong><i class="fa fa-inr"></i>&#8358;<?php echo number_format($order_data->paid,2); ?></strong></h5></td>
          </tr>
          <tr>
            <td class="text-right" colspan="4"><h5><strong>Balance: </strong></h5></td>
            
            <td class="text-right text-danger"><h5><strong><i class="fa fa-inr"></i>&#8358;<?php echo number_format($order_data->due,2); ?></strong></h5></td>
          </tr>
          </tbody>
        </table>
      </div>
      
      <div class="row">
        <div class="receipt-header receipt-header-mid receipt-footer">
          <div class="col-xs-8 col-sm-8 col-md-8 text-left">
            <div class="receipt-right">
              <p><b>Delivery Note :</b> <strong> <?php echo $delivery_report->note;?></strong> </p>
              <h5 class="text-danger text-bold"> Authorized: <?php echo $delivery_report->signed_by;?></h5>
            </div>
          </div>
          <div class="col-xs-4 col-sm-4 col-md-4">
            <div class="receipt-left">
              <div class="text-right">
                <h1 class="text-center">
                  <img id="kspQrcode"  src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?php echo $order_data->invoiceNo;?>" width="80" alt="">
                </h1>
                <small class="text-danger text-right">Scan for RefCode</small>
              </div>
            
            </div>
          </div>
        </div>
      </div>
    
    </div>
  </div>
</div>

</body>
</html>