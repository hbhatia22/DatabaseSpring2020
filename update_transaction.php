<?php
include 'dbconfig.php';
// echo "<a href = 'logout.html'>User Logout</a><br><br>";
echo "<a href = 'logout.php'>User Logout</a>";



if (isset($_POST['submit'])) {

    $num_count = count($_POST['note']);
    $num_delete = 0;
    $num_update = 0;

    for ($i=0; $i < $num_count; $i++) {
        $note[$i] = $_POST['note'][$i];
        $delete[$i] = $_POST['delete'][$i];
        $id[$i] = $_POST['id'][$i];

        $q1 = "SELECT *
                FROM CPS3740_2020S.Money_bhatiaha
                WHERE mid = $id[$i]";

        $r1 = mysqli_query($conn, $q1);
        $rows = mysqli_fetch_array($r1);
        $old_note = $rows['note'];

        if($old_note != $note[$i]){
            $q2 = "UPDATE CPS3740_2020S.Money_bhatiaha
                    SET note = '$note[$i]'
                    WHERE mid = $id[$i]";
            
            $r2 = mysqli_query($conn, $q2);
            $num_update++;
        }
        if(isset($delete[$i])) {
            $q3 = "DELETE
                    FROM CPS3740_2020S.Money_bhatiaha
                    WHERE mid = $delete[$i]";
                
            $r3 = mysqli_query($conn, $q3);
            $num_delete++;
        }
    }

    echo "<br>$num_update transaction notes have been updated";
    echo "<br>$num_delete transactions have been deleted";
}
else {
    echo "<br> Try again. updates unsuccessful.";
}

?>
