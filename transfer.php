
<?php
session_start();
if(!isset($_SESSION['userId'])){ header('location:login.php');}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Banking</title>
  <?php require 'assets/autoloader.php'; ?>
  <?php require 'assets/db.php'; ?>
  <?php require 'assets/function.php'; ?>
  <?php
    $error = "";
    if (isset($_POST['userLogin']))
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
          $_SESSION['user'] = $data;
          header('location:index.php');
         }
        else
        {
          $error = "<div class='alert alert-warning text-center rounded-0'>Username or password wrong try again!</div>";
        }
    }

   ?>
</head>
<body style="background:#ffffff;background-size: 100%">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
 <a class="navbar-brand" href="#">
   <!--  <i class="d-inline-block  fa fa-building fa-fw"></i> --><?php echo bankName; ?>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item ">
        <a class="nav-link " href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item ">  <a class="nav-link" href="accounts.php">Account</a></li>
      <li class="nav-item ">  <a class="nav-link" href="statements.php">Statements</a></li>
      <li class="nav-item active">  <a class="nav-link" href="transfer.php">Send</a></li>
      <!-- <li class="nav-item ">  <a class="nav-link" href="profile.php">Profile</a></li> -->


    </ul>
    <?php include 'sideButton.php'; ?>
  </div>
</nav><br><br><br>
<div class="container">
  <div class="card  w-75 mx-auto">
  <div class="card-header text-center">
    Funds Transfer
    <!-- /* Req. 1.1.0 Customer/user should be allowed to send money after input account number of receiver. */ -->

  </div>  
  <div class="card-body">
      <form method="POST" action="transfer.php">
          <div class="alert alert-success w-50 mx-auto">
            <h5>New Transfer</h5> 
            <input type="text" name="otherNo" class="form-control " placeholder="Enter Receiver's Account Number" required>
            <button type="submit" name="get" value="get" class="btn btn-primary btn-bloc btn-sm my-1">Get Account Info</button>
          </div>
      </form>
      <?php if (isset($_POST['get'])) 
      {
          $con = new mysqli('localhost','u854424063_manager','dO;hr&uT4','u854424063_mybank');
          $otherNO = $_POST['otherNo'];
          $array2 = $con->query("SELECT * FROM otheraccounts WHERE accountNo = '$otherNO'");
        //   print_r($array2);
          $array3 = $con->query("SELECT * FROM useraccounts WHERE accountNo = '$otherNO'");
        //   print_r($array3);
        //   echo $array3->num_rows;
        //   echo $otherNO;
        // {
          if ($array2->num_rows > 0) 
          { $row2 = $array2->fetch_assoc();
            echo "<div class='alert alert-success w-50 mx-auto'>
                  <form method='POST'>
                    Account No.
                    <input type='text' value='$row2[accountNo]' name='otherNo' class='form-control ' readonly required>
                    Account Holder Name.
                    <input type='text' class='form-control' value='$row2[holderName]' readonly required>
                    Account Holder Bank Name.
                    <input type='text' class='form-control' value='$row2[bankName]' readonly required>
                    Enter Amount for tranfer.
                    <input type='number' name='amount' class='form-control' min='1' max='$userData[balance]' required>
                    <button type='submit' name='transfer' class='btn btn-primary btn-bloc btn-sm my-1'>Tranfer</button>
                  </form>
                </div>";
          }elseif ($array3->num_rows > 0) {
          $row2 = $array3->fetch_assoc();
          ?>
                <div class='alert alert-success w-50 mx-auto'>
                  <form method='POST'>
                    Account No.
                    <input type='text' value="<?=$row2['accountNo']?>" name='otherNo' class='form-control ' readonly required>
                    Account Holder Name.
                    <input type='text' class='form-control' value="<?=$row2['name']?>" readonly required>
                    Account Holder Bank Name.
                    <input type='text' class='form-control' value='<?php echo bankName ?>' readonly required>
                    Enter Amount for tranfer.     <!-- /* Req. 1.1.1 Amount of the money should be provided. */ -->

                    <input type='number' name='amount' class='form-control' min='1' max="<?=$userData['balance']?>" required>
                    <button type='submit' name='transferSelf' value="transferSelf" class='btn btn-primary btn-bloc btn-sm my-1'>Tranfer</button>
                  </form>
                </div>
                <?php
          }
          else
            echo "<div class='alert alert-success w-50 mx-auto'>Account No. $_POST[otherNo] Does not exist.</div>";
        // }
      } 
      ?>
    <br>
    <h5>Transfer History</h5>
    <?php
    if (isset($_POST['transferSelf']))
    {
      $amount = $_POST['amount'];
      setBalance($amount,'debit',$userData['accountNo']);
      setBalance($amount,'credit',$_POST['otherNo']);
      makeTransaction('transfer',$amount,$_POST['otherNo']);
    //   echo "<script>alert('Transfer Successfull');window.location.href='transfer.php'</script>";
    }
    if (isset($_POST['transfer']))
    {
      $amount = $_POST['amount'];
      setBalance($amount,'debit',$userData['accountNo']);
      makeTransaction('transfer',$amount,$_POST['otherNo']);
      echo "<script>alert('Transfer Successfull');window.location.href='transfer.php'</script>";
    }
      $array = $con->query("select * from transaction where userId = '$userData[id]' AND action = 'transfer' order by date desc");
      if ($array ->num_rows > 0) 
      {
         while ($row = $array->fetch_assoc()) 
         {
            if ($row['action'] == 'transfer') 
            {
              echo "<div class='alert alert-warning'>Transfer have been made for  $$row[debit] from your account at $row[date] in  account no.$row[other]</div>";
            }

         }
      }
      else
        echo "<div class='alert alert-info'>You have made no transfer yet.</div>";
    ?>  
  </div>
  <div class="card-footer text-muted">
   <?php echo bankName ?>
  </div>
</div>

</div>
</body>
</html>
