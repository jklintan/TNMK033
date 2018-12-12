<?php
    include 'head.php';
?>

    <script type="text/javascript">
        function validate() {
            var url = document.getElementById("url").value;
            var pattern = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
            if (pattern.test(url)) {
                return true;
            }
            return false;
        }
    </script>
<body class="toplists">
    <?php 
        include 'header.php';
    ?>
        
    <div class="container">
        <h1> Topplists! </h1>

        <div class="row">
            <div class="column">
                    <div class="columnitem">
                    <h3>Lego sets with most pieces! </h3>
                    <?php
                        //The 10 sets with most pieces in total 
                        $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
                        if(mysqli_error($connection)) {
                            die("<p>MySQL error:</p><p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
                        }

                        $topPiece = "SELECT DISTINCT(SetID), SUM(inventory.Quantity) AS totalpieces FROM inventory GROUP BY SetID ORDER BY totalpieces DESC LIMIT 1";
                        $contents = mysqli_query($connection, $topPiece);

                        if(mysqli_num_rows($contents) == 0) {
                            print("<p>Error in reading of data...</p>\n");
                        } else {
                            while($row = mysqli_fetch_array($contents)) {
                                $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
                                $ItemID = $row[0];
                                $pieces = $row[1];
                                $getSetName = "SELECT sets.Setname, inventory.ItemTypeID, inventory.ColorID FROM sets, inventory WHERE sets.SetID='$ItemID'";
                                $fetch = mysqli_query($connection, $getSetName);
                                $name = mysqli_fetch_array($fetch);
                                
                                $filename = "SL/$ItemID.jpg";
                                print("<p> $name[0] </p> <p> Antal bitar: $pieces </p>");
                                print("<td><img title='$prefix$filename' src=\"$prefix$filename\" alt=\"Part $ItemID\"/></td>");
                            }
                        }
                        mysqli_close($connection);
                    ?>
                </div>
            </div>

            <div class="column">
                <div class="columnitem">
                    <h3>Året med flest legoset! </h3>
                    <?php
                        $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //connect to lego db

                        if(!$connection){
                            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>\n</body>\n</html>\n"); //Error message if connection failed
                        }
                        
                        //query database for number how many sets were released during a year
                        $orderedSets = "SELECT Year, COUNT(*) FROM sets GROUP BY Year ORDER BY COUNT(*) DESC LIMIT 1";
                        $query = mysqli_query($connection, $orderedSets);
                        //assign values from database into an array
                        while($assoc = mysqli_fetch_array($query)){
                            print("<h4> $assoc[0]</h4> <p> Antal satser: $assoc[1] </p>");
                            $i++;
                        }
                    ?>
                </div>
                
                <div class="columnitem">
                    <h3>Fakta från samling: </h3>
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
                                    print("<p> Antal Set: $row[0] </p>");
                                }
                                while($row2 = mysqli_fetch_array($resultP)) {
                                    print("<p> Antal bitar totalt: $row2[0] </p>");
                                }
                            }
                            mysqli_close($connection);

                        ?>
                </div>
            
                <div class="columnitem">
                    <h3>Den mest populära biten </h3>
                        <?php
                            //The most popular piece
                            $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
                            if(mysqli_error($connection)) {
                                die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
                            }

                            $topPiece = "SELECT COUNT(ItemID) FROM inventory ORDER BY COUNT(ItemID) ASC LIMIT 1";
                            $content = mysqli_query($connection, $topPiece);

                            if(mysqli_num_rows($content) == 0) {
                                print("<p>Error in reading of data...</p>\n");
                            } else {
                                while($row = mysqli_fetch_array($content)) {
                                    $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
                                    $ItemID = $row[0];
                                    $getSetName = "SELECT parts.Partname, inventory.ColorID inventory.ItemTypeID, inventory.ColorID FROM parts, inventory WHERE parts.PartID='$ItemID' AND inventory.ItemID = '$ItemID";
                                    $fetch = mysqli_query($connection, $getSetName);
                                    $name = mysqli_fetch_array($fetch);
                                    $ColorID = $name['ColorID'];
                                    print("$ColorID");
                                    print("$name[1]");
                                
                                    $filename = "P/$ColorID/$ItemID.jpg";
                                    print(" <b> $name[0] </b> ");
                                    print("<td><img title='$prefix$filename' src=\"$prefix$filename\" alt=\"Part $ItemID\"/></td>");
                                }
                            }
                            mysqli_close($connection);
                        ?>
                </div>
        </div>

    </div>
    </body>
</html>