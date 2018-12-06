<html>
    <!-- Visa ett historgram för alla bitar i satserna  -->
    <?php
        $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //Connect to Lego database
        if(!$connection){
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>\n</body>\n</html>\n"); //Error message if connection failed
        }
        //$data = "SELECT * FROM sets WHERE sets.Setname LIKE 'Castle'";
        $data = SELECT COUNT(DISTINCT inventory.SetID) FROM inventory";
        $contents = mysqli_query($connection, $data);
        if(mysqli_num_rows($contents) == 0) {
            print("<p>No parts in inventory for this set.</p>\n");
        }else{

            $things = [];

            while ($row = mysqli_fetch_array($contents)) {
                $things[] = $row;
            }
            for($i = 0; $i < $length = count($things); $i++) {
                $things[$i]['Bit'] = $things[$i][0];
                $things[$i]['Antal'] = $things[$i][1];
                unset($things[$i][1]);
                unset($things[$i][0]);
            }
            $things[0]['title'] = 'Bitar i valt set';
            
            
            
            
            //Print results
        //     print("<table>\n<tr>");
        //     print("<th>Tabell</th>");
        //     print("</tr>\n");
        //     $setQuery = mysqli_query($connection, $data);
        //     $setname = mysqli_fetch_array($setQuery);
        //     echo("Setname: ");
        //     echo($setname[0]);
        //     print("</table>\n");
        // }
    ?>

</html>