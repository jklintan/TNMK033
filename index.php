<!DOCTYPE html>
<html lang="sv">
    <head>
        <?php
            include 'head.php';
        ?>
    </head>
    <body>
        <?php
            include 'header.php';
        ?>
        <div class="start">
            <div class="centerBox">
                <img src="assets/img/lego.svg" alt="">
                <div id="searchField">
                <form action="search.php" method="GET">
                    <input required type="text" name="query" placeholder="Tanker Wagon..." autofocus>
                    <button type="submit"><i class="fas fa-search"></i></button>
                </form>         
                </div>
                <p>Sök i databasen efter ett specifikt legoset för att få reda på mer information och statistik. Scrolla ner för att se vad som finns i databasen!</p>
                <i id="scrollDownArrow" class="fas fa-chevron-down"></i>
            </div>
        </div>

        <div class="stats">
            <div class="banner"></div>
            <div class="leftGraphics"></div>
            <div class="rightGraphics"></div>
        </div>
        <?php
            include 'assets/phpModules/tidSets.php';
            include 'assets/phpModules/timeChart.php';
            include 'assets/phpModules/totalParts.php';
            include 'assets/phpModules/stegu.php';
            // include 'topplista.php';
        ?>
    </body>
</html>