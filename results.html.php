<div class="result-container animated-border">

    <?php if (isset($result) && $result !== null): ?>
        <script>
            document.getElementById('loadingSpinner').style.display = 'none';
        </script>
        <div>
            <h3 class="h3">Résultat :
                <strong class="lead"><?= htmlspecialchars($result) . $convertTo ?></strong>
            </h3>
            <hr>
            <h3 class="h3">Méthode de calcul :</h3>
            <p class="lead"><?= htmlspecialchars($conversionDescription) ?></p>
            <hr>
            <h3 class="h3">
                <small><i class='far fa-lightbulb text-warning'></i></small>
                Description :
            </h3>
            <p class="lead"><?= htmlspecialchars($detailedDescription) ?></p>
        </div>
    <?php endif; ?>

</div>
</div>
<div class="text-center mt-5">
    <p>Une suggestion ?</p>
    <p><a href="mailto:it.devwebm@gmail.com">it.devwebm@gmail.com</a></p>
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
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-MML-AM_CHTML" async></script>
</body>
</html>