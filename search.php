<head>
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/search.css" />'
</head>
<body>
<?php
    include 'head.php';
    include 'header.php';
?>
<?php

$connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
if(mysqli_error($connection)) {
    die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
}

if ($_GET['query'] == null) {
    echo "<script type='text/javascript'>alert('Please input something!');</script>";
}
else{
    $data = "SELECT DISTINCT Setname, sets.SetID FROM inventory, parts, sets WHERE sets.Setname LIKE '%$_GET[query]%'  AND ItemID=PartID AND sets.SetID=inventory.SetID 
        GROUP BY Setname, sets.SetID ORDER BY Setname, sets.SetID ASC LIMIT 24";

    $contents = mysqli_query($connection, $data);

    if (mysqli_num_rows($contents) == 0) {
        print("<p>No parts in inventory for this set.</p>\n");
    } else {
        $things = [];

        while ($row = mysqli_fetch_assoc($contents)) {
            $things[] = $row;
        }
    }

}
for ($i=0; $i < count($things); $i++) { 
    print '<h1> Sökresultat </h1> ';
    print '<div class="results">';
    for($i = 0; $i < count($things); $i++){
        print('<div class="searchCard">');
        print("<a href='/~ellze969/project/TNMK033/histogram.php?query=$SetID'>");
        $Setname = $things[$i]['Setname'];
        print("<h2>$Setname</h2>");
        $setID = $things[$i]['SetID'];
        print("<p>$setID</p>");
        $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
        $SetID = $things[$i]['SetID'];
        $filename = "SL/$SetID.jpg";
        $setURL = "$prefix$filename";
        print("<img src='$setURL'></img>");
        print("</a>");
        print('</div>');
    }
    print '</div>';
}

// Test output
// echo '<pre>';
// print_r($things);
// echo '</pre>';
$totalsResultString = addslashes(json_encode($things));

mysqli_close($connection);
?>
</body>

