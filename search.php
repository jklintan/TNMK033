<!DOCTYPE html>
<html lang="sv"> 
    <head>
        <?php
            include 'head.php';
        ?>
        <link rel="stylesheet" type="text/css" media="screen" href="assets/css/search.css" />
        <script>
        function showModal(setID) {
            document.getElementById('modal').style.pointerEvents = 'all';
            document.getElementById('modal').style.opacity = '1';
            document.getElementById('results').style.filter = 'blur(2px) brightness(50%)';
        }
        </script>
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
            $data = "SELECT DISTINCT Setname, sets.SetID FROM inventory, parts, sets WHERE sets.Setname LIKE '%$_GET[query]%'  AND ItemID=PartID AND sets.SetID=inventory.SetID 
                GROUP BY Setname, sets.SetID ORDER BY Setname, sets.SetID ASC LIMIT 24";

            $contents = mysqli_query($connection, $data);

            if (mysqli_num_rows($contents) == 0) {
                print("<p>No parts in inventory for this set.</p>");
            } else {
                $things = [];

                while ($row = mysqli_fetch_assoc($contents)) {
                    $things[] = $row;
                }
            }
        }

        print '<form action="search.php" method="GET">
        <input required type="text" name="query" placeholder="Sök igen..." autofocus>
        <button type="submit"><i class="fas fa-search"></i></button>
        </form>';

        print '<h1>Sökresultat</h1> ';

        print '<div id="results">';

        for($i = 0; $i < count($things); $i++){ 
            $SetID[] = $things[$i]['SetID'];
            $Setname = $things[$i]['Setname'];
            print("<div class='searchCard' onclick='showModal($SetID)'>");
            print("<h2>$Setname</h2>");
            print("<p>$SetID[$i]</p>");
            $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
            $filename = "SL/$SetID[$i].jpg";
            $setURL = "$prefix$filename";
            print("<img src='$setURL'></img>");
            print('</div>');
        }
        
        print '</div>';

        print '<div id="modal">';
        include 'histogram.php';
        print '<div class="statistics"> </div>';
        
        print '</div>';

        $totalsResultString = addslashes(json_encode($things));

        mysqli_close($connection);
        ?>
    </body>
</html>

