<div class="sidebar px-4 py-4 py-md-4 me-0">
    <div class="d-flex flex-column h-100">
        <a href="./" class="mb-0 brand-icon">
                    <span class="logo-icon">
                        <img src="<?php echo $Controller->get_logo();?>" width="50" height="50" class="img-fluid" style="border-radius: 50% !important;">
                    </span>
            <span class="logo-text"><?php $Controller->app_short();?></span>
        </a>
      
               <ul class="menu-list flex-grow-1 mt-3">
            <li><a class="m-link" href="./"><i class="icofont-home fs-5"></i> <span>Dashboard</span></a></li>
            <li><a class="m-link" href="stores"><i class="icofont-focus fs-5"></i> <span>Store</span></a></li>
             <li><a class="m-link" href="users"> <i class="icofont-funky-man fs-5"></i> <span>User</span></a></li>
             <li><a class="m-link" href="supplier"> <i class="icofont-funky-man fs-5"></i> <span>Supplier</span></a></li>
             <li><a class="m-link" href="category">  <i class="icofont-chart-flow fs-5"></i> <span>Category</span></a></li>
            <li><a class="m-link" href="products"> <i class="icofont-chart-histogram fs-5"></i> <span>Product</span></a></li>
             <li><a class="m-link" href="search-products"> <i class="icofont-chart-histogram fs-5"></i> <span>Barcode Scanner</span></a></li>
             <li><a class="m-link" href="expenses"> <i class="icofont-chart-histogram fs-5"></i> <span>Expenses</span></a></li>
              
            <li><a class="m-link" href="transfer"> <i class="icofont-truck fs-5"></i> <span>Transfer</span></a></li> 
            <li><a class="m-link" href="transfer-reports"> <i class="icofont-truck fs-5"></i> <span>Transfer Reports</span></a></li> 
             <li><a class="m-link" href="order-list">  <i class="icofont-truck fs-5"></i> <span>Transactions</span></a></li>
             <li><a class="m-link" href="reports">  <i class="icofont-pie-chart fs-5"></i> <span>Report</span></a></li>
                <li><a class="m-link" href="./delivery-report-list"> <i class="icofont-shopping-cart fs-5"></i> <span>Delivery Reports</span></a></li> 
             <li><a class="m-link" href="creditors">  <i class="icofont-ship fs-5"></i> <span>Creditor</span></a></li>
             <li><a class="m-link text-danger" href="expired">  <i class="icofont-ban fs-5"></i> <span>Expired</span></a></li>
             <li><a class="m-link text-danger" href="../app/View?user-action=logoutadmin" onclick="return confirm('Are you sure, You want to Sign out?');"> <i class="icofont-logout fs-5 me-3"></i> <span>Logout </span></a></li>
        </ul>
        <button type="button" class="btn btn-link sidebar-mini-btn text-light">
            <span class="ms-2"><i class="icofont-bubble-right fs-5"></i></span>
        </button>
    </div>
</div>