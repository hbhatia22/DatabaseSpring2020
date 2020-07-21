<?php
include 'dbconfig.php';

echo "<h4> The following stores are in the database </h4>";

$q1 = "SELECT sid, Name, Zipcode, State, city, address, latitude, longitude
        FROM CPS3740.Stores
        WHERE city is not null 
        and address is not null 
        and latitude is not null 
        and longitude is not null";

$r1 = mysqli_query($conn, $q1);

if ($r1) {
    if (mysqli_num_rows($r1) > 0) {
        echo "<br><table border='1'>";
        echo "<tr><th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>City</th>
            <th>State</th>
            <th>Zipcode</th>
            <th>Location(Latitude, Longitude)</th>
            </tr>";
        while($rows = mysqli_fetch_array($r1)) {
            $id = $rows['sid'];
            $name = $rows['Name'];
            $address = $rows['address'];
            $city = $rows['city'];
            $state = $rows['State'];
            $zip = $rows['Zipcode'];
            $lat = $rows['latitude'];
            $log = $rows['longitude'];

            echo "<tr>
                <td>$id</td>
                <td>$name</td>
                <td>$address</td>
                <td>$city</td>
                <td>$state</td>
                <td>$zip</td>
                <td>($lat,$log)</td>
                </tr>";
        }
    }
    else {
        echo "No stores found";
    }

}

?>