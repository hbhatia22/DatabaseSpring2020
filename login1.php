
<?php
    include 'dbconfig.php';

    $loginID = $_POST["loginID"];
    $password = $_POST["password"];
    
    $q = "SELECT login, password FROM CPS3740.Customers WHERE login='$loginID'";
    $r = mysqli_query($conn, $q);
    $rows = mysqli_num_rows($r);

    if ($rows < 1){
        echo "Incorrect login. $loginID does not exist";
        echo "<br><a href = 'project1.html'>Back to Homepage </a>";   
    }
    else{
        $q = "SELECT login, password FROM CPS3740.Customers 
        WHERE login = '$loginID' AND password ='$password'";
        $r = mysqli_query($conn, $q);
        $rows = mysqli_fetch_array($r);
        $pass = $rows['password'];
        //$password = md5($password) // to check encrypted password
        if($pass == $password){
            echo "Succesfully logged in";

            $ip = $_SERVER['REMOTE_ADDR'];
            $OS = $_SERVER['HTTP_USER_AGENT'];

            

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
            echo "<br>System info: $OS\n";
            echo "<br>Your OS is: $os\n";
            echo "<br>Your browser is: $browser\n";
		    


            $q = "SELECT name, FLOOR(DATEDIFF(CURRENT_TIMESTAMP(), DOB)/365) AS age, street, city, zipcode 
            FROM CPS3740.Customers WHERE login = '$loginID' AND password ='$password'";
            $r = mysqli_query($conn, $q);
            $rows = mysqli_fetch_array($r);

            $name = $rows['name'];
            $street = $rows['street'];
            $city = $rows['city'];
            $zipcode = $rows['zipcode'];
            $age = $rows['age'];  

            echo "<br><br>Welcome Customer: $name <br>Age: $age years<br>Address: $street, $city, $zipcode";

            echo "<br><br><hr>";

            echo "<br>The transactions for customer $name are: <br>";

            $q = "SELECT * FROM CPS3740_2020S.Money_bhatiaha";
            $r = mysqli_query($conn, $q);
            

            if($r){
                if(mysqli_num_rows($r) > 0){
                    echo "<br><table border='1'>";
                    echo "<tr><th>ID</th>
                        <th>Code</th>
                        <th>Operation</th>
                        <th>Amount</th>
                        <th>Date Time</th>
                        <th>Note</th></tr>";
                    while($rows = mysqli_fetch_array($r)){
                        $id = $rows['mid'];
                        $code = $rows['code'];
                        $o = $rows['type'];
                        $amount = $rows['amount'];
                        $balance += $amount;
                        $datetime = $rows['mydatetime'];
                        $note = $rows['note'];

                        if ($o == 'D'){
                            echo "<tr><th>$id</th>
                            <th>$code</th>
                            <th>Deposit</th>
                            <th><font color = \"blue\">$amount</font></th>
                            <th>$datetime</th>
                            <th>$note</th></tr>";
                        }
                        elseif ($o == 'W') {
                            echo "<tr><th>$id</th>
                            <th>$code</th>
                            <th>Withdraw</th>
                            <th><font color = \"red\">$amount</font></th>
                            <th>$datetime</th>
                            <th>$note</th></tr>";
                        }
                        else{
                            
                                echo "<tr><th>$id</th>
                                <th>$code</th>
                                <th>Unkown</th>
                                <th><font color = \"Yellow\">$amount</font></th>
                                <th>$datetime</th>
                                <th>$note</th></tr>";
                            
                        }

                    }
                    echo "</table>";
                    if ($balance > 0){
                        echo "<br>Total balance: <font color = \"blue\"><strong>$$balance</font></strong>";
                    }
                    elseif ($balance < 0){
                        echo "<br>Total balance: <font color = \"red\"><strong>$$balance</font></strong>";
                    }
                    else{
                        echo "<br>Total balance: <strong>$$balance</strong>";
                    }
                    
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
