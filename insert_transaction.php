<?php
include 'dbconfig.php';

// echo "<a href = 'logout.html'>User Logout</a><br><br>";
echo "<a href = 'logout.php'>User Logout</a><br><br>";

if(!isset($_COOKIE["ID"])){
	echo "Please click <a href='index.html'>here (project home page)</a> to login again<br><br>";
}

else {
    // $userName = $_COOKIE['userName'];
    // $password = $_COOKIE['password'];
    $cid = $_COOKIE['ID'];
    $name = $_COOKIE['name'];


    $trans_code = $_POST['code'];

    $q1 =   "Select * 
            from CPS3740_2020S.Money_bhatiaha
            where code = '$trans_code' and cid = $cid";
    $r1 = mysqli_query($conn, $q1);

    if (mysqli_num_rows($r1) == 0) {
        $type = $_POST['type'];
        $sid = $_POST['source'];
        $amount = $_POST['amount'];
        $note = $_POST['note'];

        $q2 = "SELECT sum(amount) as bal
                FROM CPS3740_2020S.Money_bhatiaha
                WHERE cid = $cid";

        $r2 = mysqli_query($conn, $q2);

        $row = mysqli_fetch_array($r2);
        $balance = $row['bal'];
        

        if ($type == 'D') {
            $new_balance = $balance + $amount;
            $q3 = "INSERT INTO CPS3740_2020S.Money_bhatiaha
                    (code, cid, sid, type, amount, mydatetime, note) VALUES
                    ('$trans_code', $cid, $sid, '$type', $amount, NOW(), '$note')";
            
            if(mysqli_query($conn, $q3)) {
                echo "<p1 id = 'suc'>THE TRANSACTION $trans_code WAS SUCCESSFUL</p1>";
                echo "<br><p2 id = 'suc2'>Ypur new balance is: $$new_balance</p2>";
            }
            else {
                echo "<p1 id = 'notsuc'>THE TRANSACTION WAS <font color = dark red>NOT INSERTED SUCCESSFULLY</font></p1>";
            }
        }
        else {
            if ($amount > $balance) {
                echo 'You can only withdraw less than the account balance';
            }
            else {

                $amount = $amount*(-1);
                $new_balance = $balance + $amount;
                $q4 = "INSERT INTO CPS3740_2020S.Money_bhatiaha
                        (code, cid, sid, type, amount, mydatetime, note) VALUES
                        ('$trans_code', $cid, $sid, '$type', $amount, NOW(), '$note')";

                if (mysqli_query($conn, $q4)) {
                    echo "<p1 id = 'suc'>THE TRANSACTION $trans_code WAS SUCCESSFUL</p1>";
                    echo "<br><p2 id = 'suc2'>Your new balance is: $$new_balance</p2>";
                }
                else {
                    echo "<p1 id = 'notsuc'>THE TRANSACTION WAS <font color = dark red>NOT INSERTED SUCCESSFULLY</font></p1>";
                }
                

            }

        }

    }
    else {
        echo "<p1 id = 'notsuc'>THE TRANSACTION WAS <font color = dark red>NOT INSERTED SUCCESSFULLY</font></p1>";
        echo "<p2>Transaction id must be unique</p2>";
    }


}


?>