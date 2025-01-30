<?php


class Produit
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Permet de récupérer tous les produits
     *
     * @return string (JSON)
     */
    public final function getAllProduit(): string
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM produit");
            $stmt->execute();
            $produits = $stmt->fetchAll();

            if (empty($produits)) {
                return json_encode([
                    "status" => 404,
                    "message" => "Aucun produit trouvé."
                ]);
            }

            return json_encode([
                "status" => 200,
                "data" => $produits
            ]);

        } catch (PDOException $e) {
            return json_encode([
                "status" => 500,
                "error" => "Erreur lors de la récupération des produits"
            ]);
        }

    }

    /**
     * Permet d'afficher de récupérer un produit
     *
     * @param int $id
     * @return string
     */
    public final function showProduit(int $id): string
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM produit WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $produit = $stmt->fetch();

            if ($produit) {
                return json_encode([
                    "status" => 200,
                    "data" => $produit
                ]);
            } else {
                return json_encode([
                    "status" => 404,
                    "message" => "Produit non trouvé."
                ]);
            }

        } catch(PDOException $e) {
            return json_encode([
                "status" => 500,
                "error" => "Erreur lors de la récupération du produit"
            ]);
        }
    }

    /**
     * Permet d'ajouter un produit
     *
     * @param array $data
     * @return string (JSON)
     */
    public final function addProduit(array $data): string
    {
        try {
            if (empty($data['name']) || empty($data['description']) || empty($data['price']) ||
                empty($data['category'])){
                return json_encode([
                    "status" => 400,
                    "error" => "Assurez-vous de fournir 'nom', 'description', 'prix' et 'catégorie'."
                ]);
            }

            // Préparer la requête SQL pour insérer un produit
            $query = "INSERT INTO produit (name, description, price, category_id, created, modified)
                        VALUES (:name, :description, :price, :category, :created, :modified)";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindValue(':price', $data['price'], PDO::PARAM_STR);
            $stmt->bindValue(':category', $data['category'], PDO::PARAM_INT);

            $date = (new DateTime())->format('Y-m-d H:i:s');

            $stmt->bindValue(':created', $date, PDO::PARAM_STR);
            $stmt->bindValue(':modified', $date, PDO::PARAM_STR);

            $stmt->execute();

            return json_encode([
                "status" => 201,
                "message" => "Produit ajouté avec succès."
            ]);

        } catch (PDOException $e) {
            return json_encode([
                "status" => 500,
                "error" => "Erreur lors de l'ajout du produit"
            ]);
        }
    }

    /**
     * Permet de modifier un produit
     *
     * @param int $id
     * @param array $data
     * @return string
     */
    public final function updateProduit(int $id, array $data): string
    {
        try {
            if ($id <= 0) {
                return json_encode([
                    "status" => 400,
                    "error" => "ID invalide."
                ]);
            }

            $query = "UPDATE produit SET name = :name, description = :description, price = :price,
                   category_id = :category, modified = :modified WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':name', $data['name'], PDO::PARAM_STR);
            $stmt->bindValue(':description', $data['description'], PDO::PARAM_STR);
            $stmt->bindValue(':price', $data['price'], PDO::PARAM_STR);
            $stmt->bindValue(':category', $data['category'], PDO::PARAM_INT);

            $modified = (new DateTime())->format('Y-m-d H:i:s');
            $stmt->bindValue(':modified', $modified, PDO::PARAM_STR);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return json_encode([
                    "status" => 200,
                    "message" => "Produit modifié avec succès."
                ]);
            } else {
                return json_encode([
                    "status" => 404,
                    "error" => "Produit introuvable. Aucun produit modifié."
                ]);
            }

        } catch (PDOException $e) {
            return json_encode([
                "status" => 500,
                "error" => "Erreur lors de la modification du produit"
            ]);
        }

    }

    /**
     * Permet de supprimer un produit
     *
     * @param int $id
     * @return string (JSON)
     */
    public final function deleteProduit(int $id): string
    {
        try {
            if ($id <= 0) {
                return json_encode([
                    "status" => 400,
                    "error" => "ID invalide."
                ]);
            }

            $query = "DELETE FROM produit WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return json_encode([
                    "status" => 200,
                    "message" => "Produit supprimé avec succès."
                ]);
            } else {
                return json_encode([
                    "status" => 404,
                    "error" => "Produit introuvable. Aucun produit supprimé."
                ]);
            }

        } catch(PDOException $e) {
            return json_encode([
                "status" => 500,
                "error" => "Erreur lors de la suppression du produit"
            ]);
        }

    }

}