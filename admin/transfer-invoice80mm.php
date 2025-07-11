<?php 
   require_once "helper.php";
   if (isset($_GET['trans-invid']) && $_GET['trans-invid'] !== "" && isset($_GET['action']) && $_GET['action'] === "trans-report") {
     $InvoiceId = $Controller->validate($_GET['trans-invid']);
     $transfer_data = $Controller->getTransferInvoiceDetailsById($InvoiceId);
      $store_to = $Controller->get_store_by_id($transfer_data->to_store);
      $store_from = $Controller->get_store_by_id($transfer_data->from_store);

   }else{
      echo '<script>
      window.location.assign("./transfer-reports");
      </script>';
   }
    ?>
<!DOCTYPE html>
<html>
<head>
  <?php include_once ("Includes/MetaTag.php");?>
  <title>Sales invoice</title>
</head>
<style type="text/css">
  #apDiv1 {
    position: absolute;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 1001;
  }

  hr {
    border: #ccc;
  }

  .style1 {
    font-weight: bold
  }
  </style>
</head>

<body onLoad="print();">
  <style>
  .desc {
    border-top: dashed thin #000000;
    border-bottom: dashed thin #000000
  }

  .items {
    border-bottom: dashed thin #000000
  }

  body {
    margin: 20px 50px 20 20px;
  }
  </style>
  <div style="width:50%; margin-left: 100px;">
    
    <table class="text-center" width="auto" border="0"
      style="font-size:16px; font-family:Courier; font-weight:700; margin-left:0px">
      <tr>
        <td colspan="3" align="center">
          <h4 style="margin-top:10px; font-size:21px">
            <img src="<?php echo $Controller->get_logo();?>" width="60" height="auto" alt="logo">
          </h4>
          <span style='font-size:30px;line-height:2px'><strong><?php echo strtoupper($cProfile->company);?></span></strong><br/>
          <div style='font-size:16px; font-weight:700; margin-top:0px'>
            <br><?php echo ucwords($cProfile->address);?>
            <br> Tel: <?php echo $cProfile->phone;?><br>
            Email: <?php echo $cProfile->email;?></div>
          <br />
        </td>
      </tr>
      <tr>
        <td colspan="3" align="center" style="font-size:30px; letter-spacing:0px"><strong>TRANSFER INVOICE</strong></td>
      </tr>
      <tr>
        <td>AUTHORISED</td>
        <td>:</td>
        <td><b><?php echo $transfer_data->author;?></td>
      </tr></b></td>
      </tr>
      <tr>
        <td>TRANSFER ID</td>
        <td>:</td>
        <td><?php echo $transfer_data->trNo; ?></td>
      </tr>
      <tr>
        <td>RECEIVED BY</td>
        <td>:</td>
        <td><strong><?php echo  $transfer_data->received_by; ?> </strong></td>
      </tr>
       <tr>
        <td>FROM </td>
        <td>:</td>
        <td><strong><?php echo  $store_from->store_name; ?> </strong></td>
      </tr>

      <tr>
        <td>TO </td>
        <td>:</td>
        <td><strong><?php echo  $store_to->store_name; ?> </strong></td>
      </tr>
      <tr>
        <td> DATE</td>
        <td>:</td>
        <td> <small><?php echo $Controller->get_date($transfer_data->created_at);?></small></td>
      </tr>
    </table>
    <table class="text-center" width="300" border="0"
      style="font-size:16px; font-family:Courier; font-weight:700; margin-left:0px">
      <tr>
        <td width="336" class="desc">GOODS</td>
        <td width="336" class="desc">QUANTITY</td>
        <td width="336" class="desc">&nbsp;&nbsp;&nbsp;AMOUNT</td>
      </tr>
      <tr>
        <td colspan="3">
          <table width="100%" border="0">
            <?php
             $orderLists = $Controller->getGoodsTransferedItemsList($transfer_data->id);
            if ($orderLists) {
               $cnt =0;
               foreach ($orderLists as $item) {
                $product_data = $Controller->getProductById($item->product_id);
                  $cnt++;                                 
            ?>
            <tr>
              <td width="35%" class="items"><?php echo $product_data->name;?></td>
              <td width="34%" class="items"><?php echo $item->qty;?></td>
              <td width="34%" class="items"><?php $Controller->currency();?><?php echo number_format(($item->subtotal), 2); ?></td>
            </tr>

            <?php
              }
            }

            ?>
          </table>
        </td>
      </tr>
       <tr>
        <td>TOTAL WORTH</td>
        <td>&nbsp;</td>
        <td style="border-bottom:thick#000000 double"><span
            class="style1"><?php $Controller->currency();?><?php echo number_format($transfer_data->total, 2); ?></span></td>
      </tr>
     
       
       
      <tr>
        <td colspan="3" align="center" valign="middle" style="font-size:15px">
          <hr>
          <center>
          <img id="kspQrcode"  src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data=<?php echo $transfer_data->trNo;?>" width="80" alt="">
          </center>
          <span style="border-bottom:thin #000000" align="center">
            <strong>Copyright &copy; <?php echo date("Y"); ?> <?php echo strtoupper($cProfile->company);?></strong>
          </span>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>