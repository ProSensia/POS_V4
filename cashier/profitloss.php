<?php require_once "helper.php";?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <?php include_once ("Includes/MetaTag.php");?>

    <title>::POS:: Proft & Loss </title>
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
                                <h3 class="fw-bold mb-0">PROFIT & LOSS</h3>
                                <div class="col-auto d-flex w-sm-100">
                                    <button type="button" onclick="window.location.assign('profitloss');" class="btn btn-primary btn-set-task w-sm-100"><i class="icofont-plus-circle me-2 fs-6"></i></button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Row end  -->
                    <div class="row clearfix g-3">
                        <div class="col-sm-12">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <table class="table table-hover align-middle mb-0" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>TOTAL SALES</th>
                                                <th>GROSS PROFIT (GP)</th> 
                                                <th>EXPENSES (E)</th>
                                                <th>NET PROFIT (GP- E)</th> 
                                                <!-- <th>Actions</th>   -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                             $allProfitLoss = $Controller->getProfitByStoreId($storeId);
                                             if ($allProfitLoss) {
                                                $cnt=0;
                                                 foreach ($allProfitLoss as $pl) {
                                                    $exp =  $Controller->getExpenditureByStoreId($storeId);
                                                    $cnt++;
                                                    ?>
                                                     <tr>
                                               <td><?php echo $cnt;?></td>
                                               <td><?php $Controller->currency()?><?php echo number_format($pl->sales,2);?></td>
                                               <td><?php $Controller->currency()?><?php echo number_format($pl->gross_profit,2);?></td>
                                               <td><?php $Controller->currency()?> <?php echo number_format($exp->amt,2) ?? 0.00;?></td>
                                               <td><?php $Controller->currency()?><?php if ($exp->amt) {
                                                echo number_format(($pl->gross_profit -$exp->amt),2);
                                               }else{
                                                echo number_format($pl->gross_profit,2);
                                               } ?></td>
                                               <!-- <td><button class="btn btn-danger btn-sm"><span class="icofont-ui-delete text-white"></span></button></td> -->
                                           </tr>

                                                    <?php 
                                                 }
                                             }else{
                                                $Controller->no_record_found(5);
                                             }

                                            ?>
                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!-- Row End -->
                </div>
            </div>
            
          
        </div>
             
    </div>
    
    <!-- Jquery Core Js -->
    <?php include_once ("Includes/FooterGeneralScript.php");?>
    <script>
        // project data table
        $(document).ready(function() {
           
        });
    </script>
</body>

</html>