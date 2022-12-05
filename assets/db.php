<?php 
    $con = new mysqli('localhost','u854424063_manager','dO;hr&uT4','u854424063_mybank');
    define('bankName', 'UIS Bank');
    $id = $_SESSION['userId'];
    $ar = $con->query("select * from useraccounts,branch where id = '$id' AND useraccounts.branch = branch.branchId");
    $userData = $ar->fetch_assoc();
?>
<script type="text/javascript">
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>