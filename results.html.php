
            <div class="result-container animated-border">

                <?php if (isset($result) && $result !== null): ?>
                    <script>
                        document.getElementById('loadingSpinner').style.display = 'none';
                    </script>
                    <div>
                        <h3 class="h3">Résultat :
                            <strong>
                                <?php if ($result!== null):?>
                                    <?= htmlspecialchars($result). $convertTo?>
                                <?php endif?>

                            </strong>
                        </h3>
                        <hr class="hr hr hr-blurry">
                        <h3 class="h3">Méthode de conversion :</h3>
                        Pour la conversion de  <?= htmlspecialchars($value) . $convertFrom ?> en <?= htmlspecialchars($convertTo) ?>, la méthode utilisée est :

                        <p class="lead"><?= htmlspecialchars($conversionDescription) ?></p>
                        <hr class="hr hr hr-blurry">
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
            <hr class="hr hr hr-blurry">
            <p>
                <a href="mailto:it.devwebm@gmail.com"><i class="fas fa-envelope-open"></i></a> |
                <a href="https://www.linkedin.com/in/gnpinformatique/"> <i class="fab fa-linkedin"></i></a> |
                <a href="https://github.com/teamflp"> <i class="fab fa-github"></i></a>
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

    </script>

   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (window.jspdf && typeof window.jspdf.jsPDF === 'function' && window.html2canvas) {
                const jsPDF = window.jspdf.jsPDF;

                function createPdf() {
                    const element = document.getElementById("info-container"); // L'élément contenant les informations à convertir
                    html2canvas(element).then(canvas => {
                        const imgData = canvas.toDataURL('image/png');
                        const pdf = new jsPDF({
                            orientation: 'p',
                            unit: 'mm',
                            format: 'a4'
                        });
                        const imgProps= pdf.getImageProperties(imgData);
                        const pdfWidth = pdf.internal.pageSize.getWidth();
                        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
                        pdf.save('evenements_du_jour.pdf');
                    });
                }

                document.getElementById("convertToPDFBtn").addEventListener("click", function() {
                    createPdf();
                });
            } else {
                console.error("La bibliothèque jsPDF n'a pas été correctement chargée.");
            }
        });
    </script>-->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.umd.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
    <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-MML-AM_CHTML" async></script>-->
</body>
</html>