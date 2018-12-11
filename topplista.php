<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Lego Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/default.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/main.css" />
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/toplist.css" />
        <script src="assets/js/main.js"></script>

        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>

    <div class="container">
        <h1> Topplists! </h1>

        <div class="row">
            <div class="column">
                <h3>Lego sets with most pieces! </h3>
                <?php
                    //The 10 sets with most pieces in total 
                    $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
                    if(mysqli_error($connection)) {
                        die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
                    }

                    $topPiece = "SELECT DISTINCT(SetID), SUM(inventory.Quantity) AS totalpieces FROM inventory GROUP BY SetID ORDER BY totalpieces DESC LIMIT 10";
                    $contents = mysqli_query($connection, $topPiece);

                    if(mysqli_num_rows($contents) == 0) {
                        print("<p>Error in reading of data...</p>\n");
                    } else {
                        $i = 1;
                        while($row = mysqli_fetch_array($contents)) {
                            $ItemID = $row[0];
                            $pieces = $row[1];
                            $getSetName = "SELECT Setname FROM sets WHERE sets.SetID='$ItemID'";
                            $fetch = mysqli_query($connection, $getSetName);
                            $name = mysqli_fetch_array($fetch);
                            print("<tr> $i: <b> $name[0] </b> \n Antal bitar: \n $pieces </tr>\n <br/>");
                            $i++;
                        }
                    }
                    mysqli_close($connection);
                ?>
            </div>

            <div class="column">
                <h3>The years with most lego sets! </h3>
                <?php
                    $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //connect to lego db

                    if(!$connection){
                        die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>\n</body>\n</html>\n"); //Error message if connection failed
                    }
                    
                    //query database for number how many sets were released during a year
                    $orderedSets = "SELECT Year, COUNT(*) FROM sets GROUP BY Year ORDER BY COUNT(*) DESC LIMIT 10";
                    $query = mysqli_query($connection, $orderedSets);

                    $i = 1;
                    //assign values from database into an array
                    while($assoc = mysqli_fetch_array($query)){
                        print("<tr> $i : <b>$assoc[0]</b> \n Antal satser: $assoc[1] \n </tr> </br>");
                        $i++;
                    }
                ?>
            </div>
            
            <div class="column">
                <h3>Topp 10 lego sets with fewest pieces! </h3>
                    <?php
                        //The 10 sets with most pieces in total 
                        $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
                        if(mysqli_error($connection)) {
                            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
                        }

                        $topPiece = "SELECT DISTINCT(SetID), SUM(inventory.Quantity) AS totalpieces FROM inventory GROUP BY SetID ORDER BY totalpieces ASC LIMIT 10";
                        $contents = mysqli_query($connection, $topPiece);

                        if(mysqli_num_rows($contents) == 0) {
                            print("<p>Error in reading of data...</p>\n");
                        } else {
                            $i = 1;
                            while($row = mysqli_fetch_array($contents)) {
                                $ItemID = $row[0];
                                $pieces = $row[1];
                                $getSetName = "SELECT Setname FROM sets WHERE sets.SetID='$ItemID'";
                                $fetch = mysqli_query($connection, $getSetName);
                                $name = mysqli_fetch_array($fetch);
                                print("<tr> $i: <b> $name[0] </b> \n Number of pieces: \n $pieces </tr>\n <br/>");
                                $i++;
                            }
                        }
                        mysqli_close($connection);
                    ?>
            </div>
        </div>

    </div>
    </body>
</html>