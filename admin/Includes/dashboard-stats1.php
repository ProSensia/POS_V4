<h3 class="lead text-bold text-info mb-2">Hi, <b><?php echo ($userData->username);?></b> Welcome to your Dashboard</h3>
 <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
                  <div class="col">
                     <div class="alert-success alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-success text-light"><i class="icofont-dollar fa-lg"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">Today Sales</div>
                              <span class="small"><?php $Controller->currency();?><?php echo number_format($Controller->todaySales(),2);?></span>
                              <div class="text-center"> <a href="./order-list">view</a></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="alert-danger alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-danger text-light"><i class="fa fa-credit-card fa-lg"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">Expired</div>
                              <span class="small"><?php echo number_format($Controller->CountExpired());?></span>
                              <div class="text-center"> <a href="./expired">View</a></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="alert-warning alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="fa fa-smile-o fa-lg"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">Today Invoice</div>
                              <span class="small"><?php echo $Controller->countDailyInvoice();?></span>
                              <div class="text-center"> <a href="./reports">View</a></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="alert-info alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-info text-light"><i class="fa fa-shopping-bag" aria-hidden="true"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">New Products</div>
                              <span class="small"><?php echo $Controller->countNewProducts();?></span>
                              <div class="text-center"> <a href="./products">View</a></div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>   