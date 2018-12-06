<html>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lego Project</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/default.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="assets/css/grapher.css" />
    <script src="assets/js/main.js"></script>
    <?php
        // Counts all sets in the catalog and total amount of different types of pieces in the catalog

        $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
        if(mysqli_error($connection)) {
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
        }

        // Number of unique sets
        $setID = "SELECT COUNT(DISTINCT inventory.SetID) FROM inventory";
        $setQuery = mysqli_query($connection, $setID);
        $numbOfSets = mysqli_fetch_array($setQuery);
        echo("Antal unika legosatser: ");
        echo($numbOfSets[0]);

        // Number of unique pieces
        $legoID = "SELECT COUNT(DISTINCT inventory.ItemID) FROM inventory";
        $legoQuery = mysqli_query($connection, $legoID);
        $numbOfPieces = mysqli_fetch_array($legoQuery);
        echo("Antal olika legobitar: ");
        echo($numbOfPieces[0]);

        // Store the results in an array with objects
        $data = [];
        $data[0]['title'] = 'I databasen';
        $data[0]['text'] = 'bitar';
        $data[0]['data'] = $numbOfPieces[0];
        $data[1]['title'] = 'I databasen';
        $data[1]['text'] = 'set';
        $data[1]['data'] = $numbOfSets[0];
        $totalsResultString = json_encode($data);

        // Send the results to javascript for rendering
        echo "<script type='text/javascript'>",
        "createGraph('numberSlider','$totalsResultString', '.statistics');",
        "</script>"
        ;

        mysqli_close($connection);
    ?>
</html>