<html>

    <?php

        $connection = mysqli_connect("mysql.itn.liu.se","lego","","lego"); //Connect to Lego database
        if(mysqli_error($connection)) {
            die("<p>MySQL error:</p>\n<p>" . mysqli_error($connection) . "</p>"); //Error message if connection failed
        }

        //ADD DATA FROM STEGUS COLLECTION

        mysqli_close($connection);
    ?>


</html>