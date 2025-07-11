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
            
             <li><a class="m-link" href="category">  <i class="icofont-chart-flow fs-5"></i> <span>Category</span></a></li>
            <li><a class="m-link" href="products"> <i class="icofont-chart-histogram fs-5"></i> <span>Products</span></a></li>
              
             <li><a class="m-link" href="pos"> <i class="icofont-shopping-cart fs-5"></i> <span>POS <span class="badge badge-pill bg-danger">Old</span></span></a></li>
              <li><a class="m-link" href="posv2"> <i class="icofont-shopping-cart fs-5"></i> <span>POS <span class="badge badge-pill bg-success">New</span></span></a></li>
             <li><a class="m-link" href="order-list">  <i class="icofont-truck fs-5"></i> <span>Transactions</span></a></li>
             <li><a class="m-link" href="reports">  <i class="icofont-pie-chart fs-5"></i> <span>Reports</span></a></li>
              <li><a class="m-link" href="debtors">  <i class="icofont-ship fs-5"></i> <span>Credit Sales </span></a></li>
              <li><a class="m-link" href="add-expenses"> <i class="icofont-chart-histogram fs-5"></i> <span>Expenses</span></a></li>
                <li><a class="m-link" href="profitloss"> <i class="icofont-chart-histogram fs-5"></i> <span>Profit</span></a></li>
             <li><a class="m-link text-danger" href="../app/View?user-action=logoutcashier" onclick="return confirm('Are you sure, You want to Sign out?');"> <i class="icofont-logout fs-5 me-3"></i> <span>Logout </span></a></li>
        </ul>
        <button type="button" class="btn btn-link sidebar-mini-btn text-light">
            <span class="ms-2"><i class="icofont-bubble-right fs-5"></i></span>
        </button>
    </div>
</div>