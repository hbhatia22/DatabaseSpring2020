<?php
include 'dbconfig.php';
// echo "<a href = 'logout.html'>User Logout</a><br><br>";
echo "<a href = 'logout.php'>User Logout</a>";


echo "<br> You can only edit the <strong>Note</strong> Column";
echo "<br> Select tramsactions in the check box you have to delete";

$name = $_COOKIE['name'];
$cid = $_COOKIE['ID'];

$q1 = "SELECT *
        FROM CPS3740_2020S.Money_bhatiaha m, CPS3740.Sources s
        WHERE m.cid = $cid
        AND m.sid = s.id
        order by m.mid desc";

$r1 = mysqli_query($conn, $q1);

$i = 0;

if($r1){
    if(mysqli_num_rows($r1) > 0){  
        echo "<form action = 'update_transaction.php' method ='POST'>";  
        echo "<br><table border='1'>";
        echo "<tr><th>ID</th>
            <th>Code</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Source</th>
            <th>Date Time</th>
            <th>Note</th>
            <th>Delete</th>
            </tr>";
        
        $i = 0;
        while($rows = mysqli_fetch_array($r1)){
            $id = $rows['mid'];
            $code = $rows['code'];
            $sid = $rows['sid'];
            $o = $rows['type'];
            $amount = $rows['amount'];
            $balance += $amount;
            $datetime = $rows['mydatetime'];
            $note = $rows['note'];
            $source = $rows['name'];
   
    
            
            echo "<tr><td><input type = 'text' value = '$id' name = 'id[$i]' readonly = 'true'></input></td>
                <td>$code</td>";
            if ($o == 'D') {
                echo "<td><font color = \"blue\">$amount</font></td>
                        <td>Deposit</td>";
            }
            else {
                echo "<td><font color = \"red\">$amount</font></td>
                        <td>Withdraw</td>";
            }
            echo "
                <td>$source</td>
                <td>$datetime</td>
                <td bgcolor='yellow' ><input type='text' style='background-color:yellow;' name='note[$i]' value='$note'></input></td>
                <td><input type='checkbox' name='delete[$i]' value='$id'></input></td>
                </tr>";

            $i++;
      
        }
        echo "</table>";
        if ($balance > 0){
            echo "Total balance: <font color = \"blue\"><strong>$$balance</font></strong>";
        }
        elseif ($balance < 0){
            echo "Total balance: <font color = \"red\"><strong>$$balance</font></strong>";
        }
        else{
            echo "<br>Total balance: <strong>$$balance</strong>";
        }
        
        
        echo "<br>
        <button id = 'btn' name = 'submit'>Update Transactions</button>";
        echo "</form>";
    }
}

?>