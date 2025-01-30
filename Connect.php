<?php

 class Connect
{
    private const SERVER = "localhost";
    private const USERNAME = "";
    private const PASSWORD = "";
    private const DB = "";
    private PDO $connection;

     public function __construct()
     {
         try {
             // Créer une connexion PDO
             $this->connection = new PDO("mysql:host=" . self::SERVER . ";dbname=" . self::DB, self::USERNAME, self::PASSWORD);
             // Configurer PDO pour lancer des exceptions en cas d'erreur
             $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
         } catch (PDOException $e) {
             echo json_encode([
                 "status" => 500,
                 "error" => "Erreur de connexion à la base de données"
             ]);
             exit;
         }
     }

     public final function getConnection(): PDO
     {
         return $this->connection;
     }

 }