<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/w3-css/4.1.0/w3.min.css" integrity="sha512-Z6UIAdEZ7JNzeX5M/c5QZj+oqbldGD+E8xJEoOwAx5e0phH7kdjsWULGeK5l2UjehKtChHDaUY2rQAF/NEiI9w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet"/>
    <title>
        <?php
        if (isset($result)) {
            echo "Résultat de la conversion : " . htmlspecialchars($result);
        } else {
            echo "Convertisseur d'unités CSS";
        }
        ?>
    </title>
</head>
<body>

<div class="container mt-5">
    <h1 class="text-center h1">Convertisseur d'unités CSS</h1>
    <small class="text-center d-block mb-3">px, em, rem et %</small>
    <div class="container-grid">
        <div class="form-container animated-border">
            <div>
                <details>
                    <summary>À propos de cet outil</summary>
                    <p>Vous pouvez utiliser cet outil pour convertir des valeurs de taille de police entre les unités <strong>px</strong>, <strong>em</strong>, <strong>rem</strong> et <strong>%</strong>.</p>
                    <p>Entrez une valeur, sélectionnez les unités de départ et d'arrivée, puis cliquez sur "Convertir".</p>
                    <p>La taille de police de l'élément racine ou de base est de <strong>16px</strong> par défaut. Vous pouvez la modifier si nécessaire.</p>
                </details>
            </div>
            <div class="w3-card-4">
                <div class="w3-container w3-brown mb-4">
                    <h2>CSS CONVERTER</h2>
                </div>
                <form method="post" class="needs-validation w3-container" novalidate>
                    <p class="mb-5">
                        <input type="number" class="w3-input w3-border w3-sand w3-round" id="valueInput" name="value" placeholder="Valeur initiale" required step="0.01">
                        <span class="invalid-feedback mt-2">Veuillez entrer une valeur.</span>
                    </p>
                    <p class="mb-5">
                        <select class="w3-select w3-border w3-sand w3-round" id="unitFromSelect" name="unit_from" required>
                            <option value="" disabled selected>De</option>
                            <option value="px">Pixels (px)</option>
                            <option value="rem">Rem (rem)</option>
                            <option value="em">Em (em)</option>
                            <option value="%">Pourcentage (%)</option>
                        </select>
                        <span class="invalid-feedback mt-2">Veuillez sélectionner une unité.</span>
                    </p>
                    <p class="mb-5">
                        <select class="w3-select w3-border w3-sand w3-round" id="unitToSelect" name="unit_to" required>
                            <option value="" disabled selected>À</option>
                            <option value="px">Pixels (px)</option>
                            <option value="rem">Rem (rem)</option>
                            <option value="em">Em (em)</option>
                            <option value="%">Pourcentage (%)</option>
                        </select>
                        <span class="invalid-feedback mt-2">Veuillez sélectionner une unité.</span>
                    </p>
                    <p class="mb-5">
                        <label for="baseFontSizeInput">Taille de police de base (16px)</label>
                        <input type="number" class="w3-input w3-border w3-sand w3-round" id="baseFontSizeInput" name="base_font_size" placeholder="Taille de police de base (px)" step="0.01" value="16">
                        <span class="invalid-feedback mt-2">Veuillez entrer la taille de base de la police.</span>
                    </p>
                    <p>
                        <button type="submit" class="w3-btn w3-brown w3-round btn-block">CONVERTIR</button>
                    </p>
                </form>
            </div>
        </div>

