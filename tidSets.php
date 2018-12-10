<html>
<script src="assets/js/main.js"></script>
    <?php
        $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //connect to lego db

        if(!$connection){
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>\n</body>\n</html>\n"); //Error message if connection failed
        }
        
        //query database for number how many sets were released during a year
        $orderedSets = "SELECT Year, COUNT(*) FROM sets GROUP BY Year ORDER BY Year ASC";
        $query = mysqli_query($connection, $orderedSets);

        //array for storing values fetched from database
        $setsByTime = [];

        //assign values from database into an array
        while($assoc = mysqli_fetch_assoc($query)){
            $setsByTime[] = $assoc;
        }

        //send to js for rendering
        $setsByTimeString = json_encode($setsByTime);
        echo "<script type='text/javascript'>",
        "createGraph('histogram', '$setsByTimeString', '.statistics');",
        "</script>"
        ;

        //test junk
        echo '<pre>';
        print_r($setsByTime);
        echo '</pre>';

    ?>
</html>