<?php
include 'dbconfig.php';

// echo "<a href = 'logout.html'>User Logout</a><br><br>";
echo "<a href = 'logout.php'>User Logout</a><br><br>";


if(!isset($_COOKIE['ID'])){
	echo "Please click <a href='index.html'>here (project home page)</a> to login again.<br><br>";
}
else {
    $name = $_COOKIE['name'];
    $cid = $_COOKIE['ID'];
    $keywords = $_POST['search'];

    // no keyword entered   
    if($keywords==''){
        echo "<p>No keywords entered</p>";
    }

    // show all customer transactions if keyword is '*'
    else if ($keywords=='*'){
        $q1 = "SELECT *
                FROM CPS3740_2020S.Money_bhatiaha m, CPS3740.Sources s
                WHERE m.cid = $cid
                AND m.sid = s.id
                order by m.mid desc";
        
        $r1 = mysqli_query($conn, $q1);

        echo "Showing all transaction for customer $name: <br>";
        if($r1){
            if(mysqli_num_rows($r1) > 0){                    
                echo "<br><table border='1'>";
                echo "<tr><th>ID</th>
                    <th>Code</th>
                    <th>Operation</th>
                    <th>Amount</th>
                    <th>Date Time</th>
                    <th>Note</th>
                    <th>Source</th></tr>";
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
                   
                    
                    if ($o == 'D'){
                        echo "<tr><td>$id</td>
                        <td>$code</td>
                        <td>Deposit</td>
                        <td><font color = \"blue\">$amount</font></td>
                        <td>$datetime</td>
                        <td>$note</td>
                        <td>$source</td></tr>";
                    }
                    elseif ($o == 'W') {
                        echo "<tr><td>$id</td>
                        <td>$code</td>
                        <td>Withdraw</td>
                        <td><font color = \"red\">$amount</font></td>
                        <td>$datetime</td>                            
                        <td>$note</td>
                        <td>$source</td></tr>";
                    }
                    else{                        
                        echo "<tr><td>$id</td>
                        <td>$code</td>
                        <td>Unkown</td>
                        <td><font color = \"Yellow\">$amount</font></td>
                        <td>$datetime</td>
                        <td>$note</td>
                        <td>$source</td></tr>";
                    }
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
            }
        }
    }

    
    // other cases 
    else {
        $q2 = "SELECT * 
                FROM CPS3740_2020S.Money_bhatiaha m, CPS3740.Sources s
                WHERE m.cid=$cid
                AND m.sid = s.id
                AND note LIKE CONCAT('%".$keywords."%')
                order by m.mid desc";

        $r2 = mysqli_query($conn, $q2);
        if ($r2){
            // show transactions with the keywords
            if(mysqli_num_rows($r2) > 0){                    
                echo "The transcations for customer $name with records matching keyword $keywords are:<br>";

                echo "<br><table borde'r='1'>";
                

                
                echo "<tr><th>ID</th>
                    <th>Code</th>
                    <th>Operation</th>
                    <th>Amount</th>
                    <th>Date Time</th>
                    <th>Note</th>
                    <th>Source</th></tr>";
                while($rows = mysqli_fetch_array($r2)){
                    $id = $rows['mid'];
                    $code = $rows['code'];
                    $sid = $rows['sid'];
                    $o = $rows['type'];
                    $amount = $rows['amount'];
                    $balance += $amount;
                    $datetime = $rows['mydatetime'];
                    $note = $rows['note'];
                    $source = $rows['name'];
                   
                    
                    if ($o == 'D'){
                        echo "<tr><td>$id</td>
                        <td>$code</td>
                        <td>Deposit</td>
                        <td><font color = \"blue\">$amount</font></td>
                        <td>$datetime</td>
                        <td>$note</td>
                        <td>$source</td></tr>";
                    }
                    elseif ($o == 'W') {
                        echo "<tr><td>$id</td>
                        <td>$code</td>
                        <td>Withdraw</td>
                        <td><font color = \"red\">$amount</font></td>
                        <td>$datetime</td>                            
                        <td>$note</td>
                        <td>$source</td></tr>";
                    }
                    else{                        
                        echo "<tr><td>$id</td>
                        <td>$code</td>
                        <td>Unkown</td>
                        <td><font color = \"Yellow\">$amount</font></td>
                        <td>$datetime</td>
                        <td>$note</td>
                        <td>$source</td></tr>";
                    }
                    
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
            }
            // no transactions found with keywords
            else {
                echo "No transactions found for customer $name matching the keyword $keywords";
            }
            
        }
        
        
    }
}

?>