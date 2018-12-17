<?php
    include 'head.php';
?>
<body>
<?php
    include 'header.php';
?>
</body>
    <div class="start">
        <div class="centerBox">
            <img src="assets/img/lego.svg" alt="">
            <div id="searchField">
                <input type="text" name="" placeholder="Star Wars..." id="" autofocus>
                <i class="fas fa-search"></i>
                <!-- <p class="cardlayout">Lorem ipsum dolor amet woke aesthetic hella kickstarter, craft beer vaporware sartorial air plant echo park drinking vinegar kale chips schlitz hashtag flannel. Blue bottle af jianbing trust fund migas venmo green juice man bun pabst meggings post-ironic etsy hexagon. Listicle pork belly seitan, cornhole man bun narwhal cray irony. Kinfolk fam readymade portland, truffaut authentic kitsch meditation asymmetrical biodiesel prism.</p> -->
            </div>
            <p>Sök i databasen efter ett specifikt legoset för att få reda på mer information och statistik. Scrolla ner för att se vad som finns i databasen!</p>
            <i id="scrollDownArrow" class="fas fa-chevron-down"></i>
        </div>
    </div>

    <div class="stats">
        <div class="grapher speedometer" data-grapher="{}"></div>
    </div>
    <?php
        include 'tidSets.php';
        include 'assets/phpModules/totalParts.php';
    ?>
</body>
</html>