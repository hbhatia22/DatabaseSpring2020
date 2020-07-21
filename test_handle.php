<?php
		$userName = $_GET['userName'];
		$password = $_GET['password'];
		echo "<br>User name: $userName\n";
		echo "<br>Password: $password\n";

		$ip = $_SERVER['REMOTE_ADDR'];
		echo "<br>You are from IP: $ip\n";
		$IPv4 = explode('.', $ip);
		if ($IPv4[0] == 10){
			echo "<br>You are log in from Kean University";
		}
		else{
			echo "<br>You are NOT log in from Kean University";
		}

		include "dbconfig.php";

		$q = "SELECT * FROM Customers WHERE login='$userName'";
		echo "<br>query: $q";

		$result = mysqli_query($conn, $q);

		if ($result) {
			if (mysqli_num_rows($result) > 0) {
				while ($row = mysqli_fetch_array($result)) {
					if ($password == $row['pass']) {
						echo "<br>Login successful\n";
						echo "<br>Welcome ";
					}
				}
				mysqli_free_result($result);
			}
			else {
				echo "<br>No records found in the database\n";
			}
		}
		else {
			echo "<br>Error: ". mysqli_error($conn);
		}
		mysqli_close($conn);
?>
