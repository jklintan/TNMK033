<!DOCTYPE html>
<html>
    <body>

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


        //Toplist most used pieces 
        $content = mysqli_query($connection, "SELECT inventory.Quantity, inventory.ItemTypeID, inventory.ItemID, inventory.ColorID, colors.Colorname, parts.Partname FROM inventory, parts, colors WHERE inventory.SetID='375-2' AND inventory.ItemTypeID='P' AND inventory.ItemID=parts.PartID AND inventory.ColorID=colors.ColorID");
        if(mysqli_num_rows($content) == 0) {
            print("<p>No parts in inventory for this set.</p>\n");
        } else {
            print("<table>\n<tr>");
            print("<th>Quantity</th>");
            print("<th>Picture</th>");
            print("<th>Color</th>");
            print("<th>Part name</th>");
            print "</tr>\n";
            while($row = mysqli_fetch_array($contents)) {
                print("<tr>");
                $Quantity = $row['Quantity'];
                print("<td>$Quantity</td>");
                $prefix = "http://www.itn.liu.se/~stegu76/img.bricklink.com/";
                $ItemID = $row['ItemID'];
                $ColorID = $row['ColorID'];
                $imagesearch = mysqli_query($connection, "SELECT * FROM images WHERE ItemTypeID='P' AND ItemID='$ItemID' AND ColorID=$ColorID");
                $imageinfo = mysqli_fetch_array($imagesearch);
                if($imageinfo['has_jpg']) { // Use JPG if it exists
	                $filename = "P/$ColorID/$ItemID.jpg";
                } else if($imageinfo['has_gif']) { // Use GIF if JPG is unavailable
	                $filename = "P/$ColorID/$ItemID.gif";
                } else { // If neither format is available, insert a placeholder image
	                $filename = "noimage_small.png";
                }
                print("<td><img title='$prefix$filename' src=\"$prefix$filename\" alt=\"Part $ItemID\"/></td>");
                $Colorname = $row['Colorname'];
                $Partname = $row['Partname'];
                print("<td style='color: $Colorname'>$Colorname</td>");
                print("<td>$Partname</td>");
                print("</tr>\n");
            }
            print("</table>\n");
        }



        //Get yellow toplist
        $topPieceColor = "SELECT inventory.SetID, sets.Setname, inventory.Quantity FROM inventory, sets WHERE sets.SetID=inventory.SetID AND inventory.ColorID=3 ORDER BY inventory.Quantity DESC LIMIT 10";
        $colorContents = mysqli_query($connection, $topPieceColor);
        if(mysqli_num_rows($colorContents) == 0) {
            print("<p>No parts in inventory for this set.</p>\n");
        } else {

            while($row = mysqli_fetch_array($colorContents)) {
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


    </body>
</html>