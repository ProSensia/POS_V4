<?php
require_once "app/Controller.php";
$Controller = new Controller();
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<!-- A Product of KodeMadeEazy| FlatERP Teach -->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php $Controller->app(); ?>:: Create Account</title>
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon"> <!-- Favicon-->

    <!-- project css file  -->
    <link rel="stylesheet" href="assets/css/main.style.min.css">
    <link rel="stylesheet" type="text/css" href="assets/plugin/toastr/toastr.min.css">

</head>
<body>
    <div id="ebazar-layout" class="theme-blue">

        <!-- main body area -->
        <div class="main p-2 py-3 p-xl-5">
            
            <!-- Body: Body -->
            <div class="body d-flex p-0 p-xl-5">
                <div class="container-xxl">

                    <div class="row g-0">
                        <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center">
                            <div style="max-width: 25rem;">
                                <div class="text-center mb-5">
                                   <img src="<?php echo $Controller->get_logo();?>" width="50" height="50" class="img-fluid">
                                </div>
                                <div class="mb-2">
                                    <h2 class="color-900 text-center fw-bold text-info"><strong><?php $Controller->app();?></strong>
                                        </h2>
                                </div>
                                <!-- Image block -->
                                <div class="">
                                    <img src="assets/images/login-img.png" alt="login-img">
                                </div>
                            </div>
                        </div>
<!-- A Product of KodeMadeEazy| FlatERP Teach -->
                        <div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                            <div class="w-100 p-3 p-md-3 card border-0 shadow-sm" style="max-width: 32rem;">
                                <!-- Form -->
                                <form class="row g-1 p-3 p-md-4" id="newDemoAdminForm" autocomplete="off">
                                    <div class="col-12 text-center mb-2">
                                        <h1>Register</h1>
                                        
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                           
                                            <input type="text" class="form-control form-control-lg" placeholder="Full Name" name="fullname">
                                        </div>
                                    </div>
                                      <input type="hidden" name="action" value="create_new_demo_admin_account_">
                                    <div class="col-12">
                                        <div class="mb-2">
                                           
                                            <input type="text" class="form-control form-control-lg" placeholder="Email address" name="email">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                           
                                            <input type="tel" class="form-control form-control-lg" placeholder="Phone" name="phone">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                          
                                            <input type="text" name="username" class="form-control form-control-lg" placeholder="Username">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                           
                                            <input type="password" name="password" class="form-control form-control-lg" placeholder="Password 8+ characters required">
                                        </div>
                                    </div>
                                  
                                    <div class="col-12 col-md-12 text-center mt-2">
                                      <button type="submit" class="btn btn-lg btn-block btn-dark lift loginLoading" style="width: 100% !important;">REGISTER</button>
                                    </div>
                                     <p class="m-1"> Already have an Account? <a href="./" class="text-info">Login here</a></p>
                                    <?php $Controller->copyRight();?>
                                    
                                </form>
                                <!-- End Form -->
                                <!-- A Product of KodeMadeEazy| FlatERP Teach -->
                            </div>
                        </div>
                    </div> <!-- End Row -->
                    
                </div>
            </div>

        </div>

    </div>

    <!-- Jquery Core Js -->
    <script src="assets/bundles/libscripts.bundle.js"></script>
    <script src="assets/plugin/toastr/toastr.min.js"></script>
    <script src="assets/js/kme-toastr.js"></script>
    <div id="server-response"></div>
    <script>
        $(document).ready(function(){
    $("#newDemoAdminForm").on("submit",function(e){
        e.preventDefault();
        $(".loginLoading").html('<img src="assets/loaders/tail-spin.svg" width="25">').attr("disabled", "disabled");
        const formData = $(this).serialize();
       $.post("app/View",formData,function(data){
           setTimeout(function(){
               $(".loginLoading").html("REGISTER").attr("disabled", false);
               $("#server-response").html(data);
           },1000)
       })
    })
        })
    </script>
</body>

</html>