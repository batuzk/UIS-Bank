<?php

# The following function is called whenever your program needs to input data.
# You can change it to use other sources rather than fgets().
function input() {
    return fgets(STDIN);
}
$balance = 0;
$eOJ = "1";
echo "Name?" . PHP_EOL;
$name = input();
echo "Surname?" . PHP_EOL;
$surname = input();
echo "Welcome " . $name . "!" . PHP_EOL;
echo "Balance: $" . $balance . PHP_EOL;
while ($eOJ != "3") {
    echo " What would you like to do?" . PHP_EOL;
    echo "(1) = Deposit Money" . PHP_EOL;
    echo "(2) = Withdraw Money" . PHP_EOL;
    echo "(3) = Exit" . PHP_EOL;
    $eOJ = input();
    if ($eOJ != "3") {
        if ($eOJ == "1") {
            echo "How much would you like to deposit from primary payment method?" . PHP_EOL;
            $deposit = input();
            $deposit = $deposit;
            echo "The amount is: $" . $deposit . PHP_EOL;
            echo "Do you want to countinue to deposit?" . PHP_EOL;
            echo "(1) = Yes" . PHP_EOL;
            echo "(2) = No" . PHP_EOL;
            echo "(3) = Exit" . PHP_EOL;
            $eOJ = input();
            if ($eOJ == "1") {
                echo "$" . $deposit . " deposited successfully!" . PHP_EOL;
                $cbalance = $balance + $deposit;
                $balance = $cbalance;
                echo "Current balance: $" . $cbalance . PHP_EOL;
            }
        } else {
            echo "How much would you like to withdraw to primary payment method?" . PHP_EOL;
            $withdraw = input();
            if ($withdraw > $balance) {
                echo "We can not process this transaction, because the requested amount is greater than the available balance. Would you like to return the main menu?" . PHP_EOL;
                echo "(1) = Yes" . PHP_EOL;
                echo "(3) = No" . PHP_EOL;
                $eOJ = input();
            } else {
                echo "The amount is: $" . $withdraw . PHP_EOL;
                echo "Do you want to countinue to withdraw?" . PHP_EOL;
                echo "(1) = Yes" . PHP_EOL;
                echo "(2) = No" . PHP_EOL;
                echo "(3) = Exit" . PHP_EOL;
                $eOJ = input();
                if ($eOJ == "1") {
                    echo "$" . $withdraw . " withdraw is successful!" . PHP_EOL;
                    $cbalance = $cbalance - $withdraw;
                    $balance = $cbalance;
                    echo "Current balance: $" . $cbalance . PHP_EOL;
                }
            }
        }
    }
}
echo "Thank you " . $name . " " . $surname . "!" . PHP_EOL;
echo "Current balance: $" . $balance . PHP_EOL;
?>
