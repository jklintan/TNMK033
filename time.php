<html>
<?php
    include 'head.php';
?>
<body>
<?php
    include 'header.php';
?>
    <script>
        const createTimeChart = (timeData) => {
        const output = JSON.stringify(timeData)
        console.log(output)
        const tallest = findTallestData(timeData)
        const parent = document.createElement('div')
        const scrollbox = document.createElement('div')
        const title = document.createElement('h2')
        title.textContent = timeData.title



        parent.classList.add('grapher', 'histogram')
        parent.appendChild(title)

        let delay = 0
        const step = 10 / timeData.length
        const length = timeData.data
        timeData.data.forEach(entry => {
            const bar = createLine(entry, timeData.dataType, tallest)
            bar.style.animationDelay = delay + 'ms'
            delay += step
            scrollbox.appendChild(bar)
        })
        const spacer = document.createElement('div')
        scrollbox.appendChild(spacer)
        scrollbox.classList.add('slider')
        parent.appendChild(scrollbox)
        return parent
    }
    </script>



    <div class="stats">
            <canvas id="canvasTime">

            </canvas>
    </div>

        <script>
            var canvas = document.getElementById("canvasTime");
            var ctx = canvas.getContext("2d");
            ctx.moveTo(0, 0);
            ctx.lineTo(200, 100);
            ctx.stroke();

            
        </script>

    <?php
        //include 'assets/phpModules/timeChart.php';
    ?>

</body>

</html>
