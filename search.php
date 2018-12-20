<!DOCTYPE html>
<html lang="sv"> 
    <head>
        <?php
            include 'head.php';
        ?>
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/search.css" />
    </head>

    <body>
    
        <?php
            include 'header.php';
        ?>

        <?php

        $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
        if(mysqli_error($connection)) {
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
        }

        if ($_GET['query'] == null) {
            
        }
        else{
            print '<form action="search.php" method="GET">
            <input required type="text" name="query" placeholder="Sök igen..." autofocus>
            <button type="submit"><i class="fas fa-search"></i></button>
            </form>';

            print "<h1>Sökresultat för $_GET[query]</h1>";

            $data = "SELECT DISTINCT Setname, sets.SetID FROM inventory, parts, sets WHERE sets.Setname LIKE '%$_GET[query]%'  AND ItemID=PartID AND sets.SetID=inventory.SetID 
                GROUP BY Setname, sets.SetID ORDER BY Setname, sets.SetID ASC LIMIT 24";

            $contents = mysqli_query($connection, $data);

            if (mysqli_num_rows($contents) == 0) {
                print("<div class='searchCard'><p>Din sökning gav inga resultat...</p></div>");
            } else {
                $things = [];

                while ($row = mysqli_fetch_assoc($contents)) {
                    $things[] = $row;
                }
            }
        }





        print '<div id="results">';

        for($i = 0; $i < count($things); $i++){ 
            $SetID[] = $things[$i]['SetID'];
            $Setname = $things[$i]['Setname'];
            print("<div class='searchCard'>");
            print("<a href=./histogram.php?query=$SetID[$i]>");
            print("<h2>$Setname</h2>");
            print("<p>$SetID[$i]</p>");
            $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
            $filename = "SL/$SetID[$i].jpg";
            $setURL = "$prefix$filename";
            print("<img src='$setURL'></img>");
            print('</a>');
            print("</div>");
        }
        
        print '</div>';

        $totalsResultString = addslashes(json_encode($things));

        mysqli_close($connection);
        ?>
    </body>
</html>

