

<?php
include 'dbconfig.php';

$loginID = $_POST["loginID"];
$password = $_POST["password"];
    
$q = "SELECT login, password FROM CPS3740.Customers WHERE login='$loginID'";
$r = mysqli_query($conn, $q);
$rows = mysqli_num_rows($r);

if ($rows < 1){
    echo "Incorrect login. $loginID does not exist";
    echo "<br><a href = 'index.html'>Back to Homepage </a>";   
}
else{
    $q = "SELECT login, password FROM CPS3740.Customers 
    WHERE login = '$loginID' AND password ='$password'";
    setcookie('userName', $loginID, time()+86400*30);
    setcookie('password', $password, time()+86400*30);
    $r = mysqli_query($conn, $q);
    $rows = mysqli_fetch_array($r);
    $customerID = $rows['id'];
    $pass = $rows['password'];
    //$password = md5($password) // to check encrypted password
    if($pass == $password){
        echo "<a href = 'logout.php'>User Logout</a>";

        echo "<br><br>Succesfully logged in";

        $ip = $_SERVER['REMOTE_ADDR']; //get user ip
        $OS = $_SERVER['HTTP_USER_AGENT']; //get user system info

        //show the user OS
        if(strpos($OS, 'Windows')){
            $os = "Windows";
        }
        elseif(strpos($OS, "Macintosh")){
            $os = 'Mac';
        }
        elseif(strpos($OS, 'Linux')){
            $os = 'Linux';
        }
        else {
            $os = "OS not found";
        }
        //show the user browser
        if (strpos($OS, 'Safari')){
            $browser = 'Safari';
        }
        if(strpos($OS, 'Chrome')){
            $browser = 'Chrome';
            }
        if (strpos($OS, 'Edge')) {
            $browser = 'Edge';
        }
        if (strpos($OS, 'Firefox')){
            $browser = 'Firefox';
        }
        if (strpos($OS, 'Trident')){
            $browser = 'Internet Explorer';
        }
        
            
        echo "<br><br>You are from IP: $ip\n";
        $IPv4 = explode('.', $ip);
		if ($IPv4[0] == 10 or ($IPv4[0] == 131 AND $IPv4[1] == 125)){
            echo "<br>You are <strong>logged in</strong> from Kean University";
        }
		
		else{
			echo "<br>You are <strong>NOT logged in</strong> from Kean University";
        }
        //echo "<br>System info: $OS\n";
        echo "<br>Your OS is: $os\n";
        echo "<br>Your browser is: $browser\n";
		    


        $q1 = "SELECT id, name, FLOOR(DATEDIFF(CURRENT_TIMESTAMP(), DOB)/365) AS age, street, city, zipcode 
        FROM CPS3740.Customers WHERE login = '$loginID' AND password ='$password'";
        $r1 = mysqli_query($conn, $q1);
        $rows = mysqli_fetch_array($r1);

        $ID = $rows['id'];
        $name = $rows['name'];
        $street = $rows['street'];
        $city = $rows['city'];
        $zipcode = $rows['zipcode'];
        $age = $rows['age'];  

        echo "<br><br>Welcome Customer: $name <br>Age: $age years<br>Address: $street, $city, $zipcode";
        //$cookie_name = "id";
        setcookie("ID", $ID, time()+86400*30);	
        setcookie("name", $name, time()+86400*30);

        /*if(!isset($_COOKIE)){
            echo "<br>Cookie <strong>IS NOT</strong> set.";
        }
        else {
            echo "<br>Cookie <strong>IS</strong> set. <br>
            Values is: ".$_COOKIE["ID"];
        }*/

        echo "<br><br><hr>";

        echo "<br>The transactions for customer $name are: <br>";
        // echo "<br>Customer id:  $ID";
        $q2 = "SELECT * 
                FROM CPS3740_2020S.Money_bhatiaha
                WHERE cid = $ID";
        $r2 = mysqli_query($conn, $q2);
            

        if($r2){
            if(mysqli_num_rows($r2) > 0){                    
                echo "<br><table border='1'>";
                echo "<tr><th>ID</th>
                    <th>Code</th>
                    <th>Operation</th>
                    <th>Amount</th>
                    <th>Date Time</th>
                    <th>Note</th></tr>";
                while($rows = mysqli_fetch_array($r2)){
                    $id = $rows['mid'];
                    $code = $rows['code'];
                    $sid = $rows['sid'];
                    $o = $rows['type'];
                    $amount = $rows['amount'];
                    $balance += $amount;
                    $datetime = $rows['mydatetime'];
                    $note = $rows['note'];
                   
                    
                    if ($o == 'D'){
                        echo "<tr><td>$id</td>
                        <td>$code</td>
                        <td>Deposit</td>
                        <td><font color = \"blue\">$amount</font></td>
                        <td>$datetime</td>
                        <td>$note</td></tr>";
                    }
                    else {
                        echo "<tr><td>$id</td>
                        <td>$code</td>
                        <td>Withdraw</td>
                        <td><font color = \"red\">$amount</font></td>
                        <td>$datetime</td>                            
                        <td>$note</td></tr>";
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
                setcookie("balance", $balance, time()+86400*30);
                setcookie("sid", $sid, time()+86400*30);
                setcookie("code", $code, time()+86400*30);

                        
            }
            if(!isset($_COOKIE)){
                echo "<br>Cookie not set log in again.";
            }
            else{
                echo '
                    <br>
                    <br>
                    <form action = "add_transaction.php" method="POST">
                        <input type="submit" name="add_transaction" value="Add Transations">
                    </form> 	
                    <a href="display_update_transaction.php">Display and Update Transations</a>
                    <br><br>
                    <form action ="search.php" method="POST">
                        <input type="text" name="search" placeholder="Enter transation search here: ">
                        <input type="submit" name="" value="Search Transations">
                    </form>
                ';
                
            }
        }

        
    }
    else{
        echo "Username $loginID exists but the password is incorrect";
        echo "<br><a href = 'project1.html'>Back to Homepage </a>";
    }
    

}
    
mysqli_close($conn)


?>





