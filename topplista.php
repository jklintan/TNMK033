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

    <script type="text/javascript">
        let t;
        function reload(){
            // document.addEventListener('readystatechange', event => {
            //     if (event.target.readyState === 'interactive') {
            //         reload();
            //     }
            //     else if (event.target.readyState === 'complete') {
            //         displayPage();
            //     }
            // });
            t = setTimeout(displayPage, 3000);
            //let now = new Date().getTime();
            //t = now - performance.timing.navigationStart;
        }
        function displayPage(){
            document.getElementById("loader").style.display = "none";
            document.getElementById("noshow").style.display = "block";
        }
    </script>

<body onload="reload()" class="toplists">

    <div id="loader"></div>

    <div id="noshow" class="animate-bottom">

        <?php 
            include 'header.php';
        ?>
            
        <div class="container">
            <h1> Topplista! </h1>

            <div class="row">
                <div class="column">
                    <div class="columnitem" data-aos="fade-up">
                        <h3>Lego set med flest bitar! </h3>
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

                    <div class="columnitem" data-aos="fade-up">
                        <h3>De 3 största legoseten </h3>
                        <?php
                            //The 10 sets with most pieces in total 
                            $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
                            if(mysqli_error($connection)) {
                                die("<p>MySQL error:</p><p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
                            }

                            $topPiece = "SELECT DISTINCT(SetID), SUM(inventory.Quantity) AS totalpieces FROM inventory GROUP BY SetID ORDER BY totalpieces DESC LIMIT 3";
                            $contents = mysqli_query($connection, $topPiece);

                            if(mysqli_num_rows($contents) == 0) {
                                print("<p>Error in reading of data...</p>\n");
                            } else {
                                $i = 0;
                                while($row = mysqli_fetch_array($contents)) {
                                    $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
                                    $ItemID = $row[0];
                                    $pieces = $row[1];
                                    $getSetName = "SELECT sets.Setname FROM sets, inventory WHERE sets.SetID='$ItemID'";
                                    $fetch = mysqli_query($connection, $getSetName);
                                    $name = mysqli_fetch_array($fetch);
                                    $i++;
                                    print("<p><b> $i : $name[0] </b></p> <p> Antal bitar: $pieces </p>");
                                    
                                }
                            }
                            mysqli_close($connection);
                        ?>
                    </div>

                    <div class="columnitem" data-aos="fade-up">
                        <h3>Det äldsta setet </h3>
                        <?php
                            $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //connect to lego db

                            if(!$connection){
                                die("<p>MySQL error:</p> <p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
                            }
                            
                            //query database for number how many sets were released during a year
                            $orderedSets = "SELECT Setname, Year, SetID FROM sets ORDER BY Year ASC LIMIT 1";
                            $query = mysqli_query($connection, $orderedSets);

                            while($assoc = mysqli_fetch_array($query)){
                                $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
                                $ItemID = $assoc[2];
                                $year = $assoc[1];
                                    
                                $filename = "SL/$ItemID.jpg";
                                print("<p> Satsnamn: $assoc[0] </p> <p> Från år: $assoc[1] </p>");
                                print("<img title='$prefix$filename' src=\"$prefix$filename\" alt=\"Part $ItemID\"/>");
                                $i++;
                            }
                        ?>
                    </div>

                </div>

                <div class="column">
                    <div class="columnitem" data-aos="fade-up">
                        <h3>Året med flest legoset! </h3>
                        <?php
                            $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //connect to lego db

                            if(!$connection){
                                die("<p>MySQL error:</p> <p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
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
                    
                    <div class="columnitem" data-aos="fade-up">
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
                                        $steguSets = $row[0];
                                        print("<p> Antal Set: $steguSets </p>");
                                    }
                                    while($row2 = mysqli_fetch_array($resultP)) {
                                        $steguPieces = $row2[0];
                                        print("<p> Antal bitar totalt: $steguPieces </p>");
                                    }

                                }
                                mysqli_close($connection);

                            ?>
                    </div>
                
                    <div class="columnitem" data-aos="fade-up">
                        <h3>Den vanligaste biten </h3>
                            <?php
                                //The most popular piece
                                $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
                                if(mysqli_error($connection)) {
                                    die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
                                }

                                $topPiece = "SELECT ItemID, SUM(Quantity) AS pieceSum FROM inventory WHERE ItemtypeID='P' GROUP BY ItemID ORDER BY pieceSum DESC LIMIT 1";
                                $content = mysqli_query($connection, $topPiece);

                                if(mysqli_num_rows($content) == 0) {
                                    print("<p>Error in reading of data...</p>\n");
                                } else {
                                    while($row = mysqli_fetch_array($content)) {
                                        $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
                                        $ItemID = $row[0];
                                        $getSetName = "SELECT parts.Partname, inventory.ColorID FROM parts, inventory WHERE inventory.ItemID='$ItemID' AND inventory.ItemID=parts.PartID AND ItemtypeID='P'";
                                        $fetch = mysqli_query($connection, $getSetName);
                                        $name = mysqli_fetch_array($fetch);
                                        $partname = $name[0];
                                        $ColorID = $name[1];
                                        $imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='P' AND ItemID='$ItemID' AND ColorID=$ColorID");
                                        $imageinfo = mysqli_fetch_array($imagesearch);
                                        if($imageinfo['has_jpg']) { // Use JPG if it exists
                                            $filename = "P/$ColorID/$ItemID.jpg";
                                        } else if($imageinfo['has_gif']) { // Use GIF if JPG is unavailable
                                            $filename = "P/$ColorID/$ItemID.gif";
                                        } else { // If neither format is available, insert a placeholder image
                                            $filename = "noimage_small.png";
                                        }
                                        print(" <b> $partname </b> Antal: $row[1]");
                                        print("<img title='$prefix$filename' src=\"$prefix$filename\" alt=\"Part $ItemID\"/>");
                                    }
                                }
                                mysqli_close($connection);
                            ?>
                    </div>

                    <div class="columnitem" data-aos="fade-up">
                        <h3>En av de ovanligaste bitarna </h3>
                            <?php
                                //The most popular piece
                                $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
                                if(mysqli_error($connection)) {
                                    die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
                                }

                                $topPiece = "SELECT ItemID, SUM(Quantity) AS pieceSum FROM inventory WHERE ItemtypeID='P' GROUP BY ItemID ORDER BY pieceSum ASC LIMIT 1";
                                $content = mysqli_query($connection, $topPiece);

                                if(mysqli_num_rows($content) == 0) {
                                    print("<p>Error in reading of data...</p>\n");
                                } else {
                                    while($row = mysqli_fetch_array($content)) {
                                        $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
                                        $ItemID = $row[0];
                                        $getSetName = "SELECT parts.Partname, inventory.ColorID FROM parts, inventory WHERE inventory.ItemID=parts.PartID AND inventory.ItemID='$ItemID' AND ItemtypeID='P'";
                                        $fetch = mysqli_query($connection, $getSetName);
                                        $name = mysqli_fetch_array($fetch);
                                        $partname = $name[0];
                                        $ColorID = $name[1];
                                        $imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='P' AND ItemID='$ItemID' AND ColorID=$ColorID");
                                        $imageinfo = mysqli_fetch_array($imagesearch);
                                        if($imageinfo['has_jpg']) { // Use JPG if it exists
                                            $filename = "P/$ColorID/$ItemID.jpg";
                                        } else if($imageinfo['has_gif']) { // Use GIF if JPG is unavailable
                                            $filename = "P/$ColorID/$ItemID.gif";
                                        } else { // If neither format is available, insert a placeholder image
                                            $filename = "noimage_small.png";
                                        }
                                        print(" <b> $partname </b> Antal: $row[1]");
                                        print("<img title='$prefix$filename' src=\"$prefix$filename\" alt=\"Part $ItemID\"/>");
                                    }
                                }
                                mysqli_close($connection);
                            ?>

                            <button type="button" href="http://www.student.itn.liu.se/~joskl841/project/topplista.php">Generera ny ovanlig bit!</button>

                    </div>

                    <div class="columnitem" data-aos="fade-up">
                        <h3>Det nyaste setet </h3>
                        <?php
                            $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //connect to lego db

                            if(!$connection){
                                die("<p>MySQL error:</p> <p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
                            }
                            
                            //query database for number how many sets were released during a year
                            $orderedSets = "SELECT Setname, Year, SetID FROM sets WHERE Year <>'?' ORDER BY Year DESC LIMIT 1";
                            $query = mysqli_query($connection, $orderedSets);

                            while($assoc = mysqli_fetch_array($query)){
                                $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
                                $ItemID = $assoc[2];
                                $year = $assoc[1];
                                    
                                $filename = "SL/$ItemID.jpg";
                                print("<p> Satsnamn: $assoc[0] </p> <p> Från år: $assoc[1] </p>");
                                print("<img title='$prefix$filename' src=\"$prefix$filename\" alt=\"Part $ItemID\"/>");
                                $i++;
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        AOS.init();
    </script>
    </body>
</html>