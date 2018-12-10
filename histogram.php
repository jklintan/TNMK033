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
        //$data = "SELECT Year, COUNT(*) FROM sets GROUP BY Year ORDER BY Year DESC";
        $data = "SELECT inventory.SetID, inventory.Quantity, parts.Partname 
                FROM inventory, parts 
                WHERE inventory.SetID='375-2' AND inventory.ItemtypeID='P' AND parts.PartID=inventory.ItemID";

        $contents = mysqli_query($connection, $data);
        if (mysqli_num_rows($contents) == 0) {
            print("<p>No parts in inventory for this set.</p>\n");
        }else{

            $things = [];

            while ($row = mysqli_fetch_row($contents)) {
                $things[] = $row;
            }
            for($i = 0; $i < $length = count($things); $i++) {
                $things[$i]['year'] = $things[$i][0];
                $things[$i]['amount'] = $things[$i][1];
                unset($things[$i][1]);
                unset($things[$i][0]);
            }
        }
        // Test output
        echo '<pre>';
        print_r($things);
        echo '</pre>';
        $totalsResultString = json_encode($things);

        // Send the results to javascript for rendering
        echo "<script type='text/javascript'>",
        "createGraph('histogram','$totalsResultString', '.statistics');",
        "</script>"
        ;
        
    ?>
</html>