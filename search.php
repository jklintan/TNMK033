<?php
    include 'head.php';
?>
<?php

$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
if(mysqli_error($connection)) {
    die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
}

$data = "SELECT DISTINCT Partname, Setname, SUM(Quantity) FROM inventory, parts, sets WHERE sets.Setname LIKE '%$_GET[search]%' AND ItemID=PartID AND sets.SetID=inventory.SetID GROUP BY Partname, Setname ORDER BY SUM(Quantity), Partname ASC";

$contents = mysqli_query($connection, $data);
if (mysqli_num_rows($contents) == 0) {
    print("<p>No parts in inventory for this set.</p>\n");
} else {
    $things = [];

    while ($row = mysqli_fetch_assoc($contents)) {
        $things[] = $row;
    }

}



// Test output
echo '<pre>';
print_r($things);
echo '</pre>';
$totalsResultString = addslashes(json_encode($things));

mysqli_close($connection);
?>
</html>

