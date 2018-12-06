<html>

    <?php
        //The sets with most pieces in total 

        $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
        if(mysqli_error($connection)) {
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
        }

        //$topPiece = "SELECT inventory.SetID, COUNT(inventory.Quantity) FROM inventory GROUP BY inventory.SetID ORDER BY COUNT(*) DESC LIMIT 10";
        $topPiece = "SELECT DISTINCT inventory.SetID, sets.Setname, inventory.Quantity FROM inventory, sets WHERE sets.SetID=inventory.SetID ORDER BY inventory.Quantity DESC LIMIT 10";
        $contents = mysqli_query($connection, $topPiece);

        if(mysqli_num_rows($contents) == 0) {
            print("<p>No parts in inventory for this set.</p>\n");
        } else {

            while($row = mysqli_fetch_array($contents)) {
                print("<tr>");
                print("$row[0]");
                print("<br/>");
                print("$row[1]");
                print("<br/>");
                print("$row[2]");
                print("<br/>");
                print("$row[3]");
                print("<br/>");
                print("</tr>\n");

            }
        }

        mysqli_close($connection);
    ?>

</html>