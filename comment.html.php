<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Cssconverter\Classes\DataBase;
use App\Cssconverter\Classes\CommentManager;
use App\Cssconverter\Classes\Comment;

// Créer une instance de votre base de données
$database = new DataBase('localhost', 'db_cssconverter', 'root', 'Mardochee2008');

// Vérifiez si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assainissez les données du formulaire pour éviter les injections SQL et le cross-site scripting (XSS)
    $authorName = filter_input(INPUT_POST, 'authorName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);

    // Vous pouvez ajouter ici des vérifications supplémentaires (par exemple, valider l'adresse e-mail)
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Gérer l'erreur d'e-mail invalide
        echo "L'adresse e-mail n'est pas valide.";
    } else {
        // Assurez-vous que la classe Comment a un constructeur qui accepte l'email ou un setter pour l'email
        $comment = new Comment($authorName, $content);
        $comment->setAuthorName($authorName);
        $comment->setEmail($email); // Assurez-vous que la méthode setEmail existe dans la classe Comment
        $comment->setContent($content);
        $comment->setCreatedAt(new DateTimeImmutable()); // Assurez-vous que la méthode setCreatedAt existe dans la classe Comment et que vous définissez une date

        // Créer une instance du gestionnaire de commentaires avec la base de données comme dépendance
        $commentManager = new CommentManager($database);

        try {
            $commentManager->addComment($comment);
            // Pour éviter les soumissions multiples, vous pouvez rediriger vers la même page
            //header('Location: ' . 'comment.html.php', true, 303);
            exit;
        } catch (Exception $e) {
            echo "Erreur lors de l'ajout du commentaire : " . $e->getMessage();
        }
    }
}
?>
<!-- Vous pouvez également ajouter un peu de style pour améliorer l'apparence du formulaire -->
<style>
    .comment-form-container {
        max-width: 600px;
        margin: 30px auto;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .comment-form-container h3 {
        margin-bottom: 20px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-primary {
        color: #fff;
        background-color: #007bff;
        padding: 10px 20px;
        border: none #007bff;
        border-radius: 5px;
        cursor: pointer;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .comments-container {
        margin-top: 30px;
    }

    .comment {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .comment h4 {
        margin: 0;
        color: #007bff;
    }

    .comment p {
        margin: 5px 0;
    }
</style>

<div class="comment-form-container">
    <h3>Laissez un commentaire</h3>
    <form id="commentForm" action="" method="post">
        <div class="form-group">
            <label for="commentName">Votre nom:</label>
            <input type="text" class="form-control" id="authorName" name="authorName" required>
        </div>
        <div class="form-group">
            <label for="commentEmail">Votre e-mail (ne sera pas publié):</label>
            <input type="email" class="form-control" id="commentEmail" name="email" required>
        </div>
        <div class="form-group">
            <label for="commentText">Votre commentaire:</label>
            <textarea class="form-control" id="commentText" name="content" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer le commentaire</button>
    </form>
</div>

<?php


$commentManager = new CommentManager($database);

// Récupérer les commentaires
try {
    $comments = $commentManager->getComments();
} catch (Exception $e) {
    // Traitement des erreurs (log, message d'erreur, etc.)
    die('Erreur lors de la récupération des commentaires : ' . $e->getMessage());
}

// Affichage des commentaires
echo '<div class="comments-container">';
foreach ($comments as $comment) {
    echo '<div class="comment">';
    echo '<h4>' . htmlspecialchars($comment->getAuthorName()) . '</h4>';
    echo '<p>' . htmlspecialchars($comment->getContent()) . '</p>';
    echo '<p>Posté le : ' . $comment->getCreatedAt()->format('d-m-Y à H:i:s') . '</p>';
    echo '</div>';
}
echo '</div>';
