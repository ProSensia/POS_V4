<?php 
   require_once "helper.php";
   $userId = "";
   if (isset($_GET['id']) && $_GET['id'] !== "" && isset($_GET['action']) && $_GET['action'] === "edit") {
      $userId = $Controller->validate($_GET['id']);
      $user_details = $Controller->fetchUserById("id",$userId);
      
   }else{
      echo '<script>window.location.assign("./users")</script>';
      exit();
   }
   
    ?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
   <head>
      <?php include_once ("Includes/MetaTag.php");?>
      <title>::POS:: Edit User </title>
      <!--    GENERAL SCRIPT-->
      <?php include_once ("Includes/HeaderGeneralScript.php");?>
      <!-- sidebar -->
      <?php include_once ("Includes/SideBar.php");?>
      <!-- main body area -->
      <div class="main px-lg-4 px-md-4">
         <!-- Body: Header -->
         <?php include_once ("Includes/HeaderNavBar.php");?>
         <!-- Body: Body -->
         <div class="body d-flex py-lg-3 py-md-2">
            <div class="container-xxl">
               <div class="col-md-10 offset-1">
                  <div class="row">
                     <div class="col-sm-10 col-md-10">
                        <div class="card">
                           <div class="card-header">
                              <h3 class="text-center text-info">Edit <?php echo $user_details->full_name;?>'s Profile</h3>
                           </div>
                           <div class="card-body">
                              <form id="updateUserForm" autocomplete="off">
                           <div class="row mt-2">
                              <div class="col-md-6 mb-3">
                                 <input type="hidden" name="user_id" value="<?php echo  $user_details->id;?>">
                                 <div class="form-group">
                                    <label>Full Name:</label>
                                    <input type="text" name="fullname" class="form-control form-control-lg" placeholder="Enter full name..." value="<?php echo  $user_details->full_name;?>">
                                 </div>
                              </div>
                              <div class="col-md-6 mb-3">
                                 <div class="form-group">
                                    <label>Username:</label>
                                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter username here..." value="<?php echo $user_details->username;?>">
                                 </div>
                              </div>
                              <div class="col-md-6 mb-3">
                                 <div class="form-group">
                                    <label>Email:</label>
                                    <input type="text" name="email" class="form-control form-control-lg" placeholder="Enter email here..." value="<?php echo $user_details->email;?>">
                                 </div>
                              </div>
                              
                               <div class="col-md-3 mb-3">
                                 <div class="form-group">
                                    <label>Role:</label>
                                   <select class="form-select form-control form-control-lg" name="type">
                                    <option value="<?php echo $user_details->userType;?>" selected><?php echo $user_details->userType;?></option>
                                    <option value="">Choose...</option>
                                    <option value="Administrator">Admin</option>
                                    <option value="Cashier">Cashier</option>
                                 </select>
                                 </div>
                              </div>
                              <div class="col-md-3 mb-3">
                                 <div class="form-group">
                                    <label>Active Status:</label>
                                   <select class="form-select form-control form-control-lg" name="active_status">
                                   
                                    <option value="" selected>Choose...</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                 </select>
                                 </div>
                              </div>
                              
                           </div>
                                 <?php $Controller->getKeyValuePairs("kme_users","update_user_account");?>
                                 <button type="button" onclick="window.history.back();" class="btn btn-danger text-white float-left">Go Back</button>
                                 <button type="submit" class="btn btn-primary btn-lg loading float-end">Save Changes</button>

                        </form>
                           </div>
                        </div>
                        
                     </div>
                  </div>
               </div>
            </div>
            <!-- Modal Custom Settings-->
     
 
         </div>
      </div>
      </div>
      <!-- Jquery Core Js -->
      <?php include_once ("Includes/FooterGeneralScript.php");?>
      <script>
       //
       $(document).ready(function(){
         $("#updateUserForm").on("submit",function(e){
         e.preventDefault();
         $(".loading").html('<img src="../assets/loaders/tail-spin.svg" width="25">Loading...').attr("disabled", "disabled");
         const formData = $(this).serialize();
         $.post("../app/View",formData,function(data){
            setTimeout(function(){
                $(".loading").html("Submit").attr("disabled", false);
                $("#server-response").html(data);
            },1500)
         
         })
         });
         
       });
      </script>
      </body>
</html>