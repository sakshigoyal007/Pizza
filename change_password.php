
<?php

  session_start();

  if (!isset($_SESSION["logged"])) {
    $_SESSION["pleaselogin"] = True;
    header("Location: .");
  }


include("header.php")


 ?>


 <?php
   if (isset($_POST["oldpass"])) {

   #echo phpinfo();
   $username = $_SESSION["logged"]["username"];
   $oldpass = $_POST["oldpass"];
   $newpass = $_POST["newpass"];


   try {

    $m = new MongoClient("mongodb://admin:EIIGMGVVORZLANRD@sl-eu-lon-2-portal.5.dblayer.com:20539,sl-eu-lon-2-portal.0.dblayer.com:20539/admin?ssl=true");
    $db = $m->Pizza;
    $collection = $db->users;

   } catch(Exception $e) {
     #die("Caught Exception failed to Connect".$e->getMessage()."\n");


     $error_msg = "Couldn't Connect to Database";
     $error = True;
   }
   if (!$error) {
     $result = $collection->findOne(array('username' => $username));
     #var_dump($result);

       if ($result["password"] == $oldpass) {
         //change password
         $collection->update(array("username"=>$username), array('$set'=>array("password"=>$newpass)));
         $_SESSION["pop_profile"] = "Password Updated Successfully";
         header("Location: .");
       } else {

         $error = True;
         $error_msg = "Current Password entered doesn't match";
       }

     }



   }


    ?>




 <div class="container pb-modalreglog-container">
       <div class="row">
             <div class="col-xs-12 col-md-4 col-md-offset-4">
       <div class="form" >
       <legend class="fp">Change Password</legend>
       <fieldset>
         <?php if(isset($error) AND $error) { ?>
         <div id="error" class="alert alert-danger" role="alert"><?php echo $error_msg ?></div>
       <?php } ?>
       <form method="post" action="change_password.php" onsubmit="return pswd_match();">

           <div class="form-group">
            <label for="email">Current Password</label>
             <div class="input-group pb-modalreglog-input-group">
                 <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                 <input type="password" class="form-control" name="oldpass" id="oldpass" placeholder="Enter your Current Password">

             </div>
           </div>
           <div class="form-group">
            <label for="email">New Password</label>
             <div class="input-group pb-modalreglog-input-group">
                 <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                 <input type="password" class="form-control" name="newpass" id="newpass" placeholder="Password">

             </div>
           </div>
           <div class="form-group">
            <label for="email">Confirm New Password</label>
             <div class="input-group pb-modalreglog-input-group">
                 <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                 <input type="password" class="form-control" name="confirmpass" id="confirmpass" placeholder="Confirm Password">

             </div>
           </div>


       <input type="submit" class="btn btn-warning" name="submit" value="Submit"/>
       </form></fieldset>
       </div>



 </div></div></div>



	<!-- end navigation -->

	<!-- start flexslider -->
	<!--<div class="flexslider">
		<ul class="slides">
			<li>
				<img src="images/slider-img1.jpg" alt="Pizza Image 1">
				<div class="flex-caption">
					<h2 class="slider-title">We make Pizza</h2>
					<h3 class="slider-subtitle">Fresh, clean, and delicious.</h3>
					<p class="slider-description">Praesent tincidunt neque semper elementum gravida. Donec id euismod magna. Ut erat ligula, malesuada eu quam a, fringilla auctor augue.</p>
				</div>
			</li>
			<li>
				<img src="images/slider-img2.jpg" alt="Pizza Image 2">
				<div class="flex-caption">
					<h2 class="slider-title">Freshly Baked Pizza</h2>
					<h3 class="slider-subtitle">Premium Quality, Finest Ingredients</h3>
					<p class="slider-description">Donec id euismod magna. Ut erat ligula, malesuada eu quam a, fringilla auctor augue. Praesent tincidunt neque semper elementum gravida.</p>
				</div>

			</li>
		</ul>
	</div>-->
	<!-- end flexslider -->

	<!-- start about -->

	<!-- end about -->

	<!-- start gallery -->

	<!-- end gallery -->


	<!-- end contact -->
	<!-- modals start -->


<?php include("modals.php"); ?>

<?php include("footer.php"); ?>