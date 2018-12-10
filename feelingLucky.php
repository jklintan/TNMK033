<html>
<script src="assets/js/main.js"></script>
    <?php
        $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //connect to lego db

        if(!$connection){
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>\n</body>\n</html>\n"); //Error message if connection failed
        }
        
        //query database for a random part
        $legoID = "SELECT DISTINCT ItemID FROM inventory ORDER BY RAND() LIMIT 1";
        $query = mysqli_query($connection, $legoID);

        //assign the random part to a variable
        $randomID = mysqli_fetch_assoc($query);
        
        //display part
        print($randomID[ItemID]);

    ?>
</html>