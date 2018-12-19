<html>
<script src="assets/js/main.js"></script>
    <?php
        $connection	=	mysqli_connect("mysql.itn.liu.se","lego", "", "lego"); //connect to lego db

        if(!$connection){
            die("<p>MySQL error:</p> <p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
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
        $sum = 0;
        for($i = 0; $i < count($setsByTime); $i++){
            $setsByTime[$i]['text'] = $setsByTime[$i][0];
            //Set the last element in array when all sets summed
            if ($setsByTime[$i]['text'] == '?'){ 
                $setsByTime[$i]['text'] = '2018';
            }
            $sum += $setsByTime[$i][1];
            $setsByTime[$i]['number'] = $sum;
            unset($setsByTime[$i][0]);
            unset($setsByTime[$i][1]);
        }

        //array for storing title and data, for rendering
        $legoData = [];
        $legoData['title'] = "Total sets over time";
                $legoData['data'] = $setsByTime;
                $legoData['dataType'] = "sets";

        //send to js for rendering
        $setsChange = json_encode($legoData);
        echo "<script type='text/javascript'>",
        "createGraph('timeChart', '$setsChange', '.stats');",
        "</script>"
        ;

    ?>
</html>