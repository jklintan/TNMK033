<html>
    <script src="assets/js/main.js"></script>
    <?php
        //Counts all sets in the catalog and total amount of different types of pieces in the catalog

        $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
        if(mysqli_errno($connection)) {
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
        }

        //Number of unique sets
        $setID = "SELECT COUNT(DISTINCT inventory.SetID) FROM inventory";
        $setQuery = mysqli_query($connection, $setID);
        $numbOfSets = mysqli_fetch_array($setQuery);
        echo("Antal unika legosatser: ");
        echo($numbOfSets[0]);

        //Number of unique pieces
        $legoID = "SELECT COUNT(DISTINCT inventory.ItemID) FROM inventory";
        $legoQuery = mysqli_query($connection, $legoID);
        $numbOfPieces = mysqli_fetch_array($legoQuery);
        echo("Antal olika legobitar: ");
        echo($numbOfPieces[0]);

        //Store the results in an array
        $totalsResult = array("$numbOfSets[0]", "$numbOfPieces[0]");
        $totalsResultString = json_encode($totalsResult);

        //Send the results with javascript
        echo "<script type='text/javascript'>",
        "createGraph('speedometer','$totalsResultString', '.statistics');",
        "</script>"
        ;

        mysqli_close($connection);
    ?>
</html>