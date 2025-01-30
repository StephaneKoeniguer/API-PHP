# Gestion de Produits en PHP Natif

Ce projet est une application simple de gestion de produits écrite en PHP natif avec PDO pour interagir avec une base de données MySQL. L'application permet d'effectuer des opérations CRUD (À Créer, Lire, Mettre à jour, et Supprimer) sur des produits.

## Fonctionnalités

- Récupérer tous les produits sous forme de JSON.
- Afficher un produit spécifique par son ID.
- Ajouter un nouveau produit.
- Mettre à jour un produit existant.
- Supprimer un produit par son ID.

## Prérequis

- PHP 8.0 ou plus.
- Serveur Web (Apache, Nginx, ou PHP built-in server).
- Base de données MySQL.

## Installation

1. Clonez le dépôt :

   ```bash
   git clone https://github.com/votre-utilisateur/nom-du-repo.git
   ```

2. Configurez votre base de données MySQL :

   - Créez une base de données nommée `produit_db` (ou tout autre nom que vous préférez).
   - Importez le fichier `schema.sql` pour créer la table `produit` :

     ```sql
     CREATE TABLE produit (
         id INT AUTO_INCREMENT PRIMARY KEY,
         name VARCHAR(255) NOT NULL,
         description TEXT NOT NULL,
         price DECIMAL(10, 2) NOT NULL,
         category_id INT NOT NULL,
         created DATETIME NOT NULL,
         modified DATETIME NOT NULL
     );
     ```

3. Configurez les informations de connexion à la base de données dans votre code :

   Modifiez le fichier de configuration (ou directement dans la classe `PDO` lors de l'initialisation) pour inclure votre hôte, votre nom d'utilisateur et votre mot de passe.

4. Lancez l'application :

   Si vous utilisez le serveur PHP intégré :

   ```bash
   php -S localhost:8000
   ```

5. Testez l'API avec des outils comme Postman ou cURL.

## Endpoints

### Récupérer tous les produits

- **URL** : `/produits`
- **Méthode** : `GET`
- **Réponse** :
  ```json
  {
      "status": 200,
      "data": [
          {
              "id": 1,
              "name": "Produit 1",
              "description": "Description du produit 1",
              "price": "19.99",
              "category_id": 2,
              "created": "2025-01-01 12:00:00",
              "modified": "2025-01-01 12:00:00"
          }
      ]
  }
  ```

### Récupérer un produit par ID

- **URL** : `/produits/{id}`
- **Méthode** : `GET`

### Ajouter un produit

- **URL** : `/produits`
- **Méthode** : `POST`
- **Corps** :
  ```json
  {
      "name": "Nouveau produit",
      "description": "Description du produit",
      "price": "29.99",
      "category": 1
  }
  ```

### Mettre à jour un produit

- **URL** : `/produits/{id}`
- **Méthode** : `PUT`
- **Corps** :
  ```json
  {
      "name": "Produit mis à jour",
      "description": "Nouvelle description",
      "price": "39.99",
      "category": 2
  }
  ```

### Supprimer un produit

- **URL** : `/produits/{id}`
- **Méthode** : `DELETE`

## License

Ce projet est sous licence [MIT](LICENSE).
