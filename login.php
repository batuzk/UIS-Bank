<!DOCTYPE html>
<html>
<head>
	<title>Banking</title>
	<?php require 'assets/autoloader.php'; ?>
	<?php require 'assets/function.php'; ?>
	<?php
    $con = new mysqli('localhost','u854424063_manager','dO;hr&uT4','u854424063_mybank');
    define('bankName', 'UIS Bank');
	
		$error = "";
		if (isset($_POST['userLogin'])) <!--/* Req. 1.0.0 The customer/user should provide an email address and password on the login page. */-->
		{
			$error = "";
  			$user = $_POST['email'];
		    $pass = $_POST['password'];
		   
		    $result = $con->query("select * from useraccounts where email='$user' AND password='$pass'");
		    if($result->num_rows>0)
		    { 
		      session_start();
		      $data = $result->fetch_assoc();
		      $_SESSION['userId']=$data['id'];
		      //$_SESSION['user'] = $data;
		      header('location:index.php');
		     }
		    else
		    {
		      $error = "<div class='alert alert-warning text-center rounded-0'>Username or password wrong try again!</div>";
		    }
		}
		if (isset($_POST['cashierLogin'])) /* Req. 3.0.0 Cashier should provide an email address and password on the login page. */
		{
			$error = "";
  			$user = $_POST['email'];
		    $pass = $_POST['password'];
		   
		    $result = $con->query("select * from login where email='$user' AND password='$pass'");
		    if($result->num_rows>0)
		    { 
		      session_start();
		      $data = $result->fetch_assoc();
		      $_SESSION['cashId']=$data['id'];
		      //$_SESSION['user'] = $data;
		      header('location:cindex.php');
		     }
		    else
		    {
		      $error = "<div class='alert alert-warning text-center rounded-0'>Username or password wrong try again!</div>";
		    }
		}
		if (isset($_POST['managerLogin'])) /* Req. 2.0.0 Manager should provide an email address and password on the login page. */
		{
			$error = "";
  			$user = $_POST['email'];
		    $pass = $_POST['password'];
		   
		    $result = $con->query("select * from login where email='$user' AND password='$pass' AND type='manager'");
		    if($result->num_rows>0)
		    { 
		      session_start();
		      $data = $result->fetch_assoc();
		      $_SESSION['managerId']=$data['id'];
		      //$_SESSION['user'] = $data;
		      header('location:mindex.php');
		     }
		    else
		    {
		      $error = "<div class='alert alert-warning text-center rounded-0'>Username or password wrong try again!</div>";
		    }
		}

	 ?>
</head>
<br>
<?php echo $error ?>
<br>
<div id="accordion" role="tablist" class="w-25 float-right shadowBlack" style="margin-right: 600px">
	<br><h4 class="text-center text-black">UIS Bank</h4>
  <div class="card rounded-0">
    <div class="card-header" role="tab" id="headingOne">
      <h5 class="mb-0">
        <a style="text-decoration: none;" data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         <button class="btn btn-outline-success btn-block">User Login</button>
        </a>
      </h5>
    </div>

    <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
       <form method="POST">
       	<input type="email" value="customer1@gmail.com" name="email" class="form-control" required placeholder="Enter Email">
       	<input type="password" name="password" value="customer1" class="form-control" required placeholder="Enter Password">
       	<button type="submit" class="btn btn-primary btn-block btn-sm my-1" name="userLogin">Enter </button>
       </form>
      </div>
    </div>
  </div>
  <div class="card rounded-0">
    <div class="card-header" role="tab" id="headingTwo">
      <h5 class="mb-0">
        <a class="collapsed btn btn-outline-success btn-block" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Manager Login
        </a>
      </h5>
    </div>
    <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
         <form method="POST">
       	<input type="email" value="manager@uisbank.com" name="email" class="form-control" required placeholder="Enter Email">
       	<input type="password" name="password" value="manager" class="form-control" required placeholder="Enter Password">
       	<button type="submit" class="btn btn-primary btn-block btn-sm my-1" name="managerLogin">Enter </button>
       </form>
      </div>
    </div>
  </div>
  <div class="card rounded-0">
    <div class="card-header" role="tab" id="headingThree">
      <h5 class="mb-0">
        <a class="collapsed btn btn-outline-success btn-block" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
         Cashier Login
        </a>
      </h5>
    </div>
    <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
        <form method="POST">
       	<input type="email" value="cashier@uisbank.com" name="email" class="form-control" required placeholder="Enter Email">
       	<input type="password" name="password" value="cashier" class="form-control" required placeholder="Enter Password">
       	<button type="submit"  class="btn btn-primary btn-block btn-sm my-1" name="cashierLogin">Enter </button>
       </form>
      </div>
    </div>
  </div>
</div>
</body>
</html>
