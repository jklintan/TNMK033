<?php
    include 'head.php';
?>
<body>
<?php
    include 'header.php';
?>
    <div class="start">
        <div class="centerBox">
            <img src="assets/img/lego.svg" alt="">
            <div id="searchField">
            <form action="search.php" method="GET">
                <input required type="text" name="query" placeholder="Star Wars..." id="" autofocus>
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>         
            </div>
            <p>Sök i databasen efter ett specifikt legoset för att få reda på mer information och statistik. Scrolla ner för att se vad som finns i databasen!</p>
            <i id="scrollDownArrow" class="fas fa-chevron-down"></i>
        </div>
    </div>

    <div class="stats">

    </div>
    <?php
        include 'tidSets.php';
        include 'assets/phpModules/timeChart.php';
        include 'assets/phpModules/totalParts.php';
        include 'assets/phpModules/stegu.php';
    ?>
</body>
</html>