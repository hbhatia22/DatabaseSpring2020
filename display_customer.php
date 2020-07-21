<?php
    include 'dbconfig.php';
    $q = "SELECT * FROM CPS3740.Customers";
    $r = mysqli_query($conn, $q);

    if($r){
        echo "<h4>List of customers in the bank system: </h4>";
        if (mysqli_num_rows($r) > 0){
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Login</th><th>Password</th><th>Name</th>
            <th>DOB</th><th>Gender</th><th>Street</th><th>City</th>
            <th>State</th><th>Zipcode</th></tr>";
            while($row = mysqli_fetch_array($r)){
                    $id = $row['id'];
                    $login = $row['login'];
                    $password = $row['password'];
					$name = $row['name'];
                    $DOB = $row['DOB'];
                    $gender = $row['gender'];
					$street = $row['street'];
					$city = $row['city'];
					$state = $row['state'];
					$zipcode = $row['zipcode'];

                    echo "<tr><td>$id</td>
                        <td>$login</td>
                        <td>$password</td>
                        <td>$name</td>
                        <td>$DOB</td>
                        <td>$gender</td>
                        <td>$street</td>
                        <td>$city</td>
                        <td>$state</td>
                        <td>$zipcode</td></tr>";
            }
            echo "</table>";

        }
    }


?>