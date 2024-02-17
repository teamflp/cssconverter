            <canvas id="lineCanvas" style="position: absolute; top: 0; left: 0; pointer-events: none;"></canvas>
            <div class="result-container animated-border" id="block2">

                <?php if (isset($result) && $result !== null): ?>
                    <script>
                        document.getElementById('loadingSpinner').style.display = 'none';
                    </script>
                    <div>
                        <h3 class="h3">Résultat :
                            <strong><?= htmlspecialchars($result) . $convertTo ?></strong>
                        </h3>
                        <hr class="hr">
                        <h3 class="h3">Méthode de conversion :</h3>
                        Pour la conversion de <?= htmlspecialchars($value) . $convertFrom ?> en <?= htmlspecialchars($convertTo) ?>, la méthode utilisée est :
                        <p class="lead"><?= htmlspecialchars($conversionDescription) ?></p>
                        <hr class="hr">
                        <h3 class="h3">
                            <small><i class='far fa-lightbulb text-warning'></i></small>
                            Formule de conversion :
                        </h3>
                        <p class="lead"><?= htmlspecialchars($detailedDescription) ?></p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <div class="text-center mt-5">
            <p>Une suggestion ?</p>
            <p>
                <a href="mailto:it.devwebm@gmail.com">it.devwebm@gmail.com</a> | <a href="https://www.linkedin.com/in/gnpinformatique/"> <i class="fab fa-linkedin"></i></a>
            </p>
        </div>


    </div>

    <script>
        // On désactive la soumission du formulaire si un champ est invalide
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                const forms = document.getElementsByClassName('needs-validation');
                const validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            // Afficher le spinner et soumettre le formulaire
                            document.getElementById('loadingSpinner').style.display = 'block';
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Call the function to draw the line when the window resizes and on initial load
        window.onload = drawLine;
        window.onresize = drawLine;

        function drawLine() {
            var canvas = document.getElementById('lineCanvas');
            var ctx = canvas.getContext('2d');

            // Set the canvas width and height to the window size
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            // Get the positions of the blocks
            var block1 = document.getElementById('block1').getBoundingClientRect();
            var block2 = document.getElementById('block2').getBoundingClientRect();

            // Calculate the start and end positions of the line
            var startX = block1.left+ block1.width / 1;
            var startY = block1.bottom;
            var endX = block2.left + block2.width / 700;
            var endY = block2.top;

            // Clear the canvas before drawing
            ctx.clearRect(0, 0, canvas.width, canvas.height);

            // Draw the line
            ctx.beginPath();
            ctx.moveTo(startX, startY);
            ctx.lineTo(endX, endY);
            ctx.strokeStyle = '#ccc'; // Line color
            ctx.lineWidth = 2; // Line width
            ctx.stroke();

            // Draw the text
            ctx.font = '16px Arial';
            ctx.fillStyle = '#ccc'; // Text color
            ctx.fillText('CSS CONVERTER', startX + 40, startY - 10);

        }

    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-MML-AM_CHTML" async></script>
</body>
</html>