<?php require_once "helper.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ponit Of Sales</title>
    <?php //include_once ("Includes/HeaderGeneralScript.php");?>
    <link rel="stylesheet" href="../assets/css/main.style.min.css">
   <link rel="stylesheet" type="text/css" href="../assets/plugin/toastr/toastr.min.css"> 
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
    }

    .container-fet {
      display: flex;
      height: 100vh;
    }

    .product-list {
      width: 60%;
      overflow-y: auto;
      padding: 20px;
      box-sizing: border-box;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
    }

    .product {
      border: 1px solid #ccc;
      padding: 10px;
      cursor: pointer;
      transition: background-color 0.3s, box-shadow 0.3s;
    }

    .product:hover {
      background-color: #eee;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
    }

    .selected-product {
      background-color: grey;
    }

    .cart {
      width: 40%;
      padding: 20px;
      background-color: rgb(165, 165, 165);
      box-shadow: 0 0 10px black inset;
      position: relative;
    }

    .cart-table {
      width: 100%;
      border-collapse: collapse;
      overflow-y: scroll;
    }

    .cart-table th, .cart-table td {
      border: 1px solid #ddd;
      padding: 8px;
      text-align: left;
    }

    .total-price {
      position: absolute;
      bottom: 10px;
      right: 10px;
      font-size: 18px;
      color:black;
      font-weight: 800;
    }
    .text-danger {
      color:red;
    }
  </style>
</head>
<body>
   <?php //include_once ("Includes/SideBar.php");?>
 
   <?php //include_once ("Includes/HeaderNavBar.php");?>
  <div class="container-fet">
<!-- <div>
  <form>
    <input type="search" name="keyword" placeholder="enter search keyword..." class="form-control">
  </form>
</div> -->
    <div class="product-list">
     <div style="background-color: limegreen;color: white; padding: 10px; margin-bottom: 5px;"> <h4 class="text-center"> Please click to select your product(s)</h4></div>
      <div class="product-grid">

        <?php 
      $AllProducts = $Controller->getAllProductsByStoreId($storeId);
      if ($AllProducts !="") {
       foreach ($AllProducts as $product){?>
        <div class="product addProductToCartBtn" data-id="<?php echo $product->proId;?>"><img src="../assets/images/products/<?php if ($product->image == NULL || $product->image == ""){echo 'no_image.png';}else{echo $product->image;} ?>" width="100" height="100" alt="" style="float: left; margin-right: 2px;"><span style="font-weight: bold;"><?php echo $product->name ?></span><br><br><span style="font-size: xx-small;">Stock Status:</span><?php if ($product->qty >= 1): ?>
         <span style="font-style: italic; color: limegreen;">In stock <?php echo $product->qty;?></span> 
          <?php else: ?>
           <span style="font-style: italic; color: orangered;">Out of stock <small><?php echo $product->qty;?></small></span> 
        <?php endif ?>  <br>Price: <span style="font-weight: 800; color: darkred;"><?php $Controller->currency();?><?php echo number_format($product->selling_price,2) ?></span></div>
         <?php
          }
         }
         ?>
        <!-- Add more products as needed -->
      </div>
    </div>

    <div class="cart">
      <form id="submitCheckoutForm" autocomplete="off">
        <table class="cart-table">
          <thead>
            <tr>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>X</th>
            </tr>
          </thead>
          <tbody id="cartBody">
          </tbody>
        </table>

        <div class="total-price">Total: <span id="totalPrice"></span></div>
        <input type="hidden" name="total" id="total">
        <input type="text" name="discount" onchange="superSalePrice();" id="discount" class="form-control mt-3 mb-3" placeholder="Optional discount">

        <div class="row">
            <div class="form-group col-md-6">
          <label>Payment Mode</label>
          <select class="form-control form-select-lg form-amt paymentTypeBtn" name="payment_method" style="min-width:100px" required>
         <option selected value="">Select...</option>
         <option value="Cash">Cash</option>
         <option value="POS">POS</option>
         <option value="Transfer">Transfer</option>
         <option value="Cheque">Cheque</option>
      </select>
        </div>

         <div class="form-group col-md-6">
           <label>Payable Amount</label>
          <input type="text" class="form-control" name="tenderAmount" id="tenderAmount" placeholder="Enter amount paid" required>

        </div>
         <input type="hidden" name="original_total" id="original_total">
         <div class="form-group col-md-12">
           <label>Buyer's Name</label>
          <input type="text" class="form-control" name="customer_name" id="customer_name" placeholder="Optional [Required for credit sales]">
        </div>
        <div class="form-group col-md-6">
           <label>Buyer's Phone</label>
          <input type="text" class="form-control" name="customer_phone" id="customer_phone" placeholder="Optional [Required for credit sales]">
        </div>
        <div class="form-group col-md-6">
           <label>Buyer's Email</label>
          <input type="text" class="form-control" name="customer_email" id="customer_email" placeholder="Optional [Required for credit sales]">
        </div>
        </div>
         <input type="hidden" name="cashier" value="<?=$userData->username;?>">
        <input type="hidden" name="store_id" value="<?=$storeId;?>">
        <?php $Controller->getKeyValuePairs("kme_receipt","create_new_receipt");?>

        <button type="submit" class="checkoutBtn" style="margin-top: 20px; width: 100%; background-color: lightgreen; line-height: 35px; font-weight: 700;letter-spacing: 2px;">Generate Invoice</button>
       <button type="button" onclick="window.location.assign('./');" class="btn btn-info text-white float-left mt-3">GO TO DASHBOARD</button> <a href="../app/View?user-action=logoutcashier" onclick="return confirm('Are you sure, You want to Sign out?');" class="btn btn-danger text-white float-left mt-3">LOGOUT</a>
      </form>
    </div>

  </div>

<script src="../assets/bundles/libscripts.bundle.js"></script>
<!-- Plugin Js -->
<script src="../assets/plugin/toastr/toastr.min.js"></script>
<script src="../assets/js/kme-toastr.js"></script>
<!-- Jquery Page Js -->
  <div id="server-response"></div>

  <script>
    $(document).ready(function(){

      $("#submitCheckoutForm").on("submit",function(e){
          e.preventDefault();
         
          $(".checkoutBtn").html('<img src="../assets/loaders/tail-spin.svg" width="25">Loading...').attr("disabled", "disabled");
          const fData = $(this).serialize();
         $.post("../app/View",fData,function(data){
             setTimeout(function(){
              console.log(data)
                 $(".checkoutBtn").html("Generate Invoice").attr("disabled", false);
                 $("#server-response").html(data);
                  $("#guest_name").val("");
             },700)
         });
         });

         $(document).on('click','.removeProdBtn', function(){
           $(this).closest('tr').remove();
              calculate(0,0);
              $("#paid").val(0);
         });

$(".addProductToCartBtn").on("click",function(){
              //check if the no product is selected
              $(this).css("backgroundColor","lightgray");
              var proId = $(this).data("id");
            $.ajax({
              url:"../app/View",
              type:"POST",
              data: {action:'fetch_product_id',proId:proId},
              dataType:'json',
              success:function(response){
                var html_body =`<tr>
              <td><input type="text" class="form-control form-control-lg product_name" readonly name="product_name[]" value="${response.name}"><input type="hidden" class="product_id" name="product_id[]" value="${response.proId}"> <input type="hidden" class="product_stock" name="product_stock[]" value="${response.qty}"></td>
              <td><input class="form-control form-control-lg purchaseQty" type="number" id="purchaseQty" value="1" name="purchaseQty[]" min="1" max="100" required></td>
              <td><input class="form-control form-control-lg kmePrice kmePrice_qty" readonly type="text" name="product_price[]" value="${response.selling_price}"></td>
              <input class="product_total" readonly type="hidden" id="product_total" name="product_total[]" value="${response.selling_price*1}"></td>
              <td><a href="javascript:void(0)" class="text-danger removeProdBtn" title="Remove"><i class="icofont-trash fs-5"></i></a></td></tr>`;
              $("#cartBody").append(html_body);
                calculate(0,0);
              }
           });
             
             
          });



          $('#cartBody').delegate(".purchaseQty","keyup change", function(){
          var qty_demand = $(this);
          var tr = $(this).parent().parent();
          var actualQty = parseInt(tr.find(".product_stock").val());
          if((qty_demand.val()=='0') || (parseInt(qty_demand.val()) <= -1)){
          alert("Invalid Quantity Detected!");
                      $(".checkoutBtn").attr("disabled", true);
                          return false;
          }else
          if((parseInt(qty_demand.val()) > actualQty)){
           alert("Invalid Quantity!");
                      $(".checkoutBtn").attr("disabled", true);
                          return false; 
          }else{
         parseInt(tr.find(".product_total").val(qty_demand.val() * tr.find(".kmePrice_qty").val()));
          calculate(0,0);
          $(".checkoutBtn").attr("disabled", false);
          }
         });
          });

 function calculate(paid){
          var net_total = 0;
          var paid = paid;
         
          $(".product_total").each(function(){
            net_total = net_total + ($(this).val()*1);
          })
          due = parseInt(net_total - paid);
         
          $("#total").val(net_total);
          $("#tenderAmount").val(net_total);
          $("#totalPrice").text(net_total);
          $("#original_total").val(net_total);
         }

         function superSalePrice() {
    var optionPrice = $("#total").val(); 
    var discPerc = parseFloat($("#discount").val()); 
    var total = parseFloat(optionPrice); 
    if (!isNaN(total) && discPerc !="") {
       //var applyDisc = (total * (discPerc/100));
    var rPrice = (total-discPerc);
      $("#total").val(rPrice.toFixed(2));
      $("#tenderAmount").val(rPrice.toFixed(2));
   }else{
       $("#total").val(0);
   }
   
}
    
  </script>

</body>
</html>