<!DOCTYPE html>
<html lang="sv"> 
    <head>
        
        <!-- Include head -->
        <?php
            include 'assets/phpModules/head.php';
            print("<title>Sökresultat för $_GET[query]</title>")
        ?>
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/search.css" />
    </head>

    <body>
        <?php
            include 'assets/phpModules/header.php';
        ?>

        <?php
        $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
        if(mysqli_error($connection)) {
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
        }

        //trim the query, remove unwanted whitespaces and characters
        $query = trim(preg_replace('/\s+/', ' ', $_GET['query']));

        print '<form action="search.php" method="GET">
        <input required type="text" name="query" placeholder="Sök igen..." autofocus>
        <button type="submit"><img class="searchIcon" alt="Search Button" src="./assets/img/search.svg"/></button>
        </form>';
        
        //look for empty query
        if($query == ''){
            print "<div id='errorbox'><h2>Vänligen gör inte en tom sökning. Har du testat att söka på Tanker Wagon?</h2></div>";
        }
        else{
            print "<h1>Sökresultat för $query</h1>";

            $data = "SELECT DISTINCT Setname, sets.SetID FROM inventory, parts, sets WHERE sets.Setname LIKE '%$query%'  AND ItemID=PartID AND sets.SetID=inventory.SetID 
                GROUP BY Setname, sets.SetID ORDER BY Setname, sets.SetID ASC LIMIT 24";
    
            $contents = mysqli_query($connection, $data);
            
            //show error if no sets found
            if (mysqli_num_rows($contents) == 0) {
                print("<h2>Vi hittade inga satser som matchade din sökning.</h2>");
            } else {
                $things = [];
    
                while ($row = mysqli_fetch_assoc($contents)) {
                    $things[] = $row;
                }
            }
            print("<div id='wrapper'></div>");

            //generate all the modal content
            for($j = 0; $j < count($things); $j++){ 
                $SetID[$j] = $things[$j]['SetID'];
                $Setname = $things[$j]['Setname'];
                $IDforSet = $SetID[$j];
                $_POST['query'] = $SetID[$j];
                $jsClickId = str_replace('.', '', $IDforSet);
                print("<div class='modal a$jsClickId'>");
                print("<h2>Stapeldiagram i bokstavsordning för samtliga bitar i satsen</h2>");
                print("<div class='closeButton' onclick='closeModal()'>&times;");
                print("</div>");
                print("<div class='statistics modalcontent'>");
                require ('histogram.php');
                print("</div>");
                print("</div>");
            }
            
            //make the html onerror attribute string...
            print '<div id="results">';
            $error1 = "this.src=";
            $error2 = "'assets/img/error.jpg'";
            $errorimg = "\"".$error1.$error2."\"";

            //generate all the first-level content
            for($j = 0; $j < count($things); $j++){ 
                $SetID[$j] = $things[$j]['SetID'];
                $Setname = $things[$j]['Setname'];
                $IDforSet = $SetID[$j];
                $_POST[query] = $SetID[$j];
                $altImg = str_replace('\'', '', $Setname);
                $jsClickId = str_replace('.', '', $IDforSet);
                print("<div class='searchCard' id='$jsClickId' onclick='showModal(this.id)'>");
                print("<h2>$Setname</h2>");
                print("<p>$IDforSet</p>");
                $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
                $filename = "SL/$IDforSet.jpg";
                $setURL = "$prefix$filename";
                print("<img alt='$altImg' src='$setURL' onerror=$errorimg>");
                print("</div>");
            }
            
            print '</div>';
            $totalsResultString = addslashes(json_encode($things));
        }




        mysqli_close($connection);
        ?>
    </body>
</html>

