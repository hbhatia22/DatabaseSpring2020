<?php
include 'dbconfig.php';

// echo "<a href = 'logout.html'>User Logout</a>";
echo "<a href = 'logout.php'>User Logout</a>";


echo "<br><br><h3>Add Transaction</h3>";

$name = $_COOKIE['name'];
$balance = $_COOKIE['balance'];

echo "Welcome <strong>".$name."</strong>";
if ($balance > 0){
    echo " your balance is <font color = \"blue\"><strong>$$balance</font></strong>";
}
elseif ($balance < 0){
    echo " your balance is <font color = \"red\"><strong>$$balance</font></strong>";
}
else{
    echo " your balance is <strong>$$balance</strong>";
}

echo "<form action='insert_transaction.php' method='POST'>";

echo '<br>Transaction Code: 
        <input type = "text" name="code" required="required"
            placeholder="Enter transaction ID(required)"> ';

echo '<br><input type="radio" name="type" value="D">Deposit
        <input type="radio" name="type" value="W">Withdraw';

echo '<br>Amount:
        <input type="text" name="amount" required="required"
            placeholder="Enter amount here(required)">';


#$sid = $_COOKIE['sid'];

$q1 = "SELECT * FROM CPS3740.Sources";
$r1 = mysqli_query($conn, $q1);

echo "<br>Select a Source:";
echo '<select name="source">';

    while($rows = mysqli_fetch_array($r1)){
        #$select.='<option value="'.$rows['id'].'">'.$rows['name'].'</option>';
        $source_id = $rows['id'];
        $source_name = $rows['name'];
        echo "<option value='$source_id'>$source_name</option>";
    }

echo '</select>';


echo '<br>Note:
    <input type="text" name="note" placeholder="Enter Note(if any)">';


echo '<br><br><input type="submit" name="submit" value="Submit">';

echo "</form>";
?>
