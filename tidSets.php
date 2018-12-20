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
        while($row = mysqli_fetch_row($query)){
            $setsByTime[] = $row;
        }

        //change keys for js rendering
        for($i = 0; $i < count($setsByTime) - 1; $i++){
            $setsByTime[$i]['text'] = $setsByTime[$i][0];
            $setsByTime[$i]['number'] = $setsByTime[$i][1];
            unset($setsByTime[$i][0]);
            unset($setsByTime[$i][1]);
        }
        
        //array for storing title and data, for rendering
        $legoData = [];
        $legoData['title'] = "Sets over time";
        $legoData['data'] = $setsByTime;
        $legoData['dataType'] = "sets";

        //send to js for rendering
        $setsByTimeString = json_encode($legoData);
        echo "<script type='text/javascript'>",
        "createGraph('histogram', '$setsByTimeString', '.banner');",
        "</script>"
        ;

        //test junk
        // echo '<pre>';
        // print_r($legoData);
        // echo '</pre>';
?>