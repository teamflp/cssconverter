<?php
namespace App\Cssconverter\Classes;

use Exception;
use PDO;

class DataBase
{
    private string $host;
    private string $database;
    private string $username;
    private string $password;
    private ?\PDO $connection = null;

    public function __construct(string $host, string $database, string $username, string $password)
    {
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @throws Exception
     */
    public function connect(): PDO
    {
        if ($this->connection === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            try {
                $this->connection = new PDO($dsn, $this->username, $this->password, $options);
            } catch (\PDOException $e) {
                // Vous pouvez gérer l'exception ici ou la propager plus loin
                // par exemple, enregistrer l'erreur dans un fichier de logs ou afficher un message d'erreur générique à l'utilisateur
                // throw $e; // Propager l'exception si vous voulez la gérer plus haut dans la hiérarchie de votre application
                error_log($e->getMessage());
                throw new Exception('Impossible de se connecter à la base de données.');
            }
        }

        return $this->connection;
    }

    // Si vous avez besoin de ces informations ailleurs, assurez-vous qu'elles sont utilisées de manière sécurisée
    // Sinon, vous pouvez envisager de les retirer pour renforcer la sécurité de la classe
    // public function getHost(): string { ... }
    // public function getDatabase(): string { ... }
    // public function getUsername(): string { ... }
    // public function getPassword(): string { ... }

    // Méthode pour fermer la connexion à la base de données
    public function disconnect(): void
    {
        $this->connection = null;
    }
}