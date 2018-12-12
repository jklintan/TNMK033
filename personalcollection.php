<?php
    include 'head.php';
?>


<?php
    //Summera antalet satser och bitar som Stefan har i sin samling
    $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
    if(mysqli_error($connection)) {
        die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
    }
    
    $querySets = "SELECT SUM(collection.Quantity) FROM collection";
    $queryPieces = "SELECT SUM(collection.Quantity*inventory.Quantity) FROM collection, inventory WHERE collection.SetID=inventory.SetID";
    $resultS = mysqli_query($connection, $querySets);
    $resultP = mysqli_query($connection, $queryPieces);

    if(mysqli_num_rows($resultP) == 0 || mysqli_num_rows($resultS) == 0 ) {
        print("<p>Error in reading of data...</p>\n");
    } else {
        while($row = mysqli_fetch_array($resultS)) {
            print("Antal Set som Stegu har: $row[0]");
        }
        while($row2 = mysqli_fetch_array($resultP)) {
            print("Antal bitar totalt i Stegus samling: $row2[0]");
        }
    }
    mysqli_close($connection);

?>