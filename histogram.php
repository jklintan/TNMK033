<?php
    include 'head.php';
?>
<body>
<?php
    include 'header.php';
?>
    <!-- Visa ett historgram för alla bitar i satserna  -->
    <?php
        $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //Connect to Lego database
        if (!$connection){
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>\n</body>\n</html>\n"); //Error message if connection failed
        }

        $data = "SELECT DISTINCT Partname, SUM(Quantity) FROM inventory, parts WHERE inventory.SetID='10179-1' AND ItemID=PartID 
                 GROUP BY Partname ORDER BY Partname ASC";
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

        $titleData = "SELECT Setname FROM sets WHERE sets.SetID='10179-1'";
        $titleQuery = mysqli_query($connection, $titleData);
        $title = mysqli_fetch_assoc($titleQuery);


        $legoData = [];
        $legoData['title'] = $title[Setname];
        $legoData['data'] = $things;

        $totalsResultString = addslashes(json_encode($legoData));

        // Send the results to javascript for rendering
        echo "<script type='text/javascript'>",
        "createGraph('histogram','$totalsResultString', '.statistics');",
        "</script>"
        ;
    ?>
    </body>
</html>