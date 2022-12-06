<?php 
function setBalance($amount,$process,$accountNo)
{
    // echo "<script>alert('".$accountNo."')</script>";
    // echo "Testing";
	$con = new mysqli('localhost','u854424063_manager','dO;hr&uT4','u854424063_mybank'); //Database details.
	$array = $con->query("select * from useraccounts where accountNo='$accountNo'");
	$row = $array->fetch_assoc();
// 	echo $row['balance'];
// 	echo "<script>alert('".$row['balance']."')</script>";
	if ($process == 'credit') //Add credit.
	{
		$balance = $row['balance'] + $amount;
		return $con->query("update useraccounts set balance = '$balance' where accountNo = '$accountNo'");
	}else //Remove credit.
	{
		$balance = $row['balance'] - $amount;
		return $con->query("update useraccounts set balance = '$balance' where accountNo = '$accountNo'");
	}
}
function setOtherBalance($amount,$process,$accountNo)
{
	$con = new mysqli('localhost','u854424063_manager','dO;hr&uT4','u854424063_mybank');
	$array = $con->query("select * from otheraccounts where accountNo='$accountNo'");
	$row = $array->fetch_assoc();
	if ($process == 'credit') 
	{
		$balance = $row['balance'] + $amount;
		return $con->query("update otheraccounts set balance = '$balance' where accountNo = '$accountNo'");
	}else
	{
		$balance = $row['balance'] - $amount;
		return $con->query("update otheraccounts set balance = '$balance' where accountNo = '$accountNo'");
	}
}
function makeTransaction($action,$amount,$other) //Transaction details.
{
	$con = new mysqli('localhost','u854424063_manager','dO;hr&uT4','u854424063_mybank'); //Database details.
	if ($action == 'transfer') //Transfer function.
	{
		return $con->query("insert into transaction (action,debit,other,userId) values ('transfer','$amount','$other','$_SESSION[userId]')");
	}
	if ($action == 'withdraw') //Withdraw function.
	{
		return $con->query("insert into transaction (action,debit,other,userId) values ('withdraw','$amount','$other','$_SESSION[userId]')");
		
	}
	if ($action == 'deposit') //Deposit function.
	{
		return $con->query("insert into transaction (action,credit,other,userId) values ('deposit','$amount','$other','$_SESSION[userId]')");
		
	}
}
function makeTransactionCashier($action,$amount,$other,$userId) //Cashier functions.
{
	$con = new mysqli('localhost','u854424063_manager','dO;hr&uT4','u854424063_mybank'); //Databse details.
	if ($action == 'transfer') //Transfer function.
	{
		return $con->query("insert into transaction (action,debit,other,userId) values ('transfer','$amount','$other','$userId')");
	}
	if ($action == 'withdraw') //Withdraw function.
	{
		return $con->query("insert into transaction (action,debit,other,userId) values ('withdraw','$amount','$other','$userId')");
		
	}
	if ($action == 'deposit') //Deposit function.
	{
		return $con->query("insert into transaction (action,credit,other,userId) values ('deposit','$amount','$other','$userId')");
		
	}
}
 ?>
