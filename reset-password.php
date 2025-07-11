<?php
require_once "Includes/cores.php";

if (isset($_GET['email'],$_GET['token']) && $_GET['email'] !=="" && $_GET['token'] !=="") {

    $token = $Controller->validate($_GET['token']);
    $email = $Controller->validate($_GET['email']);
        if (!$Controller->validateEmailToken($email,$token)) {
           echo "<script> 
           alert('Invalid token and email');

           window.location.assign('./forgot-password');</script>";
        }
    }else{
    echo "<script>window.location.assign('./forgot-password');</script>";
    }
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>::POS:: Password Reset </title>
    <link rel="icon" href="<?php echo $Controller->get_logo();?>" type="image/x-icon"> <!-- Favicon-->
<!-- A Product of KodeMadeEazy| FlatERP Teach -->
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
                        <div class="col-lg-6 d-none d-lg-flex justify-content-center align-items-center rounded-lg auth-h100">
                            <div style="max-width: 25rem;">
                                <div class="text-center mb-5">
                                    <!-- <i class="bi bi-bag-check-fill  text-primary" style="font-size: 90px;"></i> -->
                                    <img src="<?php echo $Controller->get_logo();?>" width="50" height="50" class="img-fluid">
                                </div>
                                <div class="mb-5">
                                    <h2 class="color-900 text-center fw-bold text-info"><strong><?php $Controller->app();?></strong></h2>
                                </div>
                                <!-- Image block -->
                                <div class="">
                                    <img src="assets/images/login-img.png" alt="login-img">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 d-flex justify-content-center align-items-center border-0 rounded-lg auth-h100">
                            <div class="w-100 p-3 p-md-5 card border-0 shadow-sm" style="max-width: 32rem;">
                                <!-- Form -->
                                <form class="row g-1 p-3 p-md-4" id="resetPasswordForm">
                                    <div class="col-12 text-center mb-2">
                                        <!-- <img src="assets/images/forgot.png" class="w240 mb-2" alt="" width="100" /> -->
                                        <h1 class="text-success">Reset Password</h1>
                                        <span class="text-info">Enter your new password and click save button</span>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">New Password</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="New password" name="password">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-2">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="text" class="form-control form-control-lg" placeholder="Confirm password" name="confirm_password">
                                        </div>
                                    </div>
                                     <input type="hidden" name="action" value="update_password_now">
                                     <input type="hidden" name="email" value="<?php echo $email;?>">
                                     <input type="hidden" name="token" value="<?php echo $token;?>">
                                    <div class="col-12 text-center mt-4">
                                       <button type="submit" class="btn btn-lg btn-block btn-dark lift loginLoading" style="width: 100% !important;">Save Changes</button>
                                    </div>
                                    <div class="col-12 text-center mt-4">
                                        <span class="text-muted"><a href="./forgot-password" class="text-danger fw-bold">Back to Sign in</a></span>
                                    </div>
                                </form>
                                <!-- End Form -->
                                
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
    $("#resetPasswordForm").on("submit",function(e){
        e.preventDefault();
        $(".loginLoading").html('<img src="assets/loaders/tail-spin.svg" width="25">').attr("disabled", "disabled");
        const formData = $(this).serialize();
       $.post("app/View",formData,function(data){
           setTimeout(function(){
               $(".loginLoading").html("Save Changes").attr("disabled", false);
               $("#server-response").html(data);
           },500)
       })
    })
        })
    </script>
</body>

</html>