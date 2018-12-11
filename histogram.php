<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lego Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/default.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/main.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/grapher.css" />
        <script src="assets/js/main.js"></script>
    </head>
    <!-- Visa ett historgram för alla bitar i satserna  -->
    <?php
        $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //Connect to Lego database
        if (!$connection){
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>\n</body>\n</html>\n"); //Error message if connection failed
        }

        $data = "SELECT DISTINCT Partname, SUM(Quantity) FROM inventory, parts, sets WHERE sets.SetID='10214-1' AND inventory.SetID='10214-1' AND ItemID=PartID GROUP BY Partname, Setname ORDER BY SUM(Quantity), Partname ASC";
 
        $contents = mysqli_query($connection, $data);
        if (mysqli_num_rows($contents) == 0) {
            print("<p>No parts in inventory for this set.</p>\n");
        } else {
            $things = [];

            while ($row = mysqli_fetch_row($contents)) {
                $things[] = $row;
            }

            for($i = 0; $i < count($things); $i++){
                $things[$i]['text'] = $things[$i][0];
                $things[$i]['number'] = $things[$i][1];
                unset($things[$i][0]);
                unset($things[$i][1]);
            }


        }

        $titleData = "SELECT Setname FROM sets WHERE sets.SetID='10214-1'";
        $titleQuery = mysqli_query($connection, $titleData);
        $title = mysqli_fetch_assoc($titleQuery);

        $object = (object) $things;

        // Test output
        echo '<pre>';
        print_r($things);
        echo '</pre>';
        $totalsResultString = addslashes(json_encode($object));

        // Send the results to javascript for rendering
        echo "<script type='text/javascript'>",
        "createGraph('histogram','$totalsResultString', '.statistics');",
        "</script>"
        ;
    ?>
</html>