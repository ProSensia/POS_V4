  <h4>Welcome to <strong><?php echo $warehouse_data->store_name; ?>.</strong></h4>
  <!-- <h3 class="lead text-bold text-info mb-2">Welcome to Salesperson Dashboard</h3> -->
 <div class="row g-3 mb-3 row-cols-1 row-cols-sm-2 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">

                  <div class="col">
                     <div class="alert-success alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-success text-light"><i class="fa fa-shopping-basket fa-lg"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">Daily Sales</div>
                              <span class="small"><?php $Controller->currency();?><?php echo number_format($Controller->todaySalesByCashier($userData->username),2); ?></span>
                              <!-- <div class="text-center"> <a href="./reports">view</a></div> -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="alert-danger alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-danger text-light"><i class="fa fa-credit-card fa-lg"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">Weekly Sales</div>
                              <span class="small"><?php echo number_format($Controller->LastSevenDaysSalesByCashier($userData->username),2); ?></span>
                              <!-- <div class="text-center"> <a href="./expired">View</a></div> -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="alert-warning alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-warning text-light"><i class="fa fa-smile-o fa-lg"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">Monthly Sales</div>
                              <span class="small"><?php echo number_format($Controller->CurrentMonthSalesrecordByCashier($userData->username),2); ?></span>
                              <!-- <div class="text-center"> <a href="stores">View</a></div> -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="alert-info alert mb-0">
                        <div class="d-flex align-items-center">
                           <div class="avatar rounded no-thumbnail bg-info text-light"><i class="fa fa-shopping-bag" aria-hidden="true"></i></div>
                           <div class="flex-fill ms-3 text-truncate">
                              <div class="h6 mb-0">Annual Sales</div>
                              <span class="small"><?php echo number_format($Controller->CurrentYearRecordBySalesRep($userData->username),2); ?></span>
                              <!-- <div class="text-center"> <a href="#">View</a></div> -->
                           </div>
                        </div>
                     </div>
                  </div>
               </div>