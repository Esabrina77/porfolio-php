<?php

/**
 * Classe Crud
 * 
 * Cette classe permet de manipuler une base de données de manière abstraite
 * en fournissant les opérations CRUD (Create, Read, Update, Delete) de base.
 * 
 * @author VotreNom
 * @package Database
 */
class Crud
{
    /** @var PDO Instance de PDO pour la connexion à la base de données */
    protected $pdo;

    /** @var string Nom de la table à manipuler */
    protected $tableName;

    /**
     * Constructeur de la classe Crud
     * 
     * @param string $tableName Nom de la table à manipuler
     * @throws PDOException Si la connexion à la base de données échoue
     */
    public function __construct(string $tableName)
    {
        $this->tableName = $tableName;
        try {
            $this->pdo = new PDO(
                "mysql:host=localhost;dbname=your_database;charset=utf8mb4",
                "username",
                "password",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            throw new PDOException("Erreur de connexion : " . $e->getMessage());
        }
    }

    /**
     * Crée un nouvel enregistrement dans la table
     * 
     * @param array $array Tableau associatif des données à insérer
     * @return mixed ID de la ligne insérée ou false en cas d'échec
     * @throws PDOException Si l'insertion échoue
     */
    public function create(array $array): mixed
    {
        $columns = implode(', ', array_keys($array));
        $values = implode(', ', array_fill(0, count($array), '?'));
        
        $sql = "INSERT INTO {$this->tableName} ($columns) VALUES ($values)";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array_values($array));
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de la création : " . $e->getMessage());
        }
    }

    /**
     * Met à jour un enregistrement existant
     * 
     * @param int $id ID de l'enregistrement à mettre à jour
     * @param array $array Tableau associatif des données à mettre à jour
     * @return bool True si succès, False si échec
     * @throws PDOException Si la mise à jour échoue
     */
    public function update(int $id, array $array): bool
    {
        $sets = array_map(function($key) {
            return "$key = ?";
        }, array_keys($array));
        
        $sql = "UPDATE {$this->tableName} SET " . implode(', ', $sets) . " WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $values = array_values($array);
            $values[] = $id;
            return $stmt->execute($values);
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de la mise à jour : " . $e->getMessage());
        }
    }

    /**
     * Supprime un enregistrement
     * 
     * @param int $id ID de l'enregistrement à supprimer
     * @return bool True si succès, False si échec
     * @throws PDOException Si la suppression échoue
     */
    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->tableName} WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de la suppression : " . $e->getMessage());
        }
    }

    /**
     * Trouve un enregistrement par son ID
     * 
     * @param int $id ID de l'enregistrement à trouver
     * @return array|false Tableau associatif des données ou false si non trouvé
     * @throws PDOException Si la recherche échoue
     */
    public function find(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE id = ?";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de la recherche : " . $e->getMessage());
        }
    }

    /**
     * Trouve des enregistrements selon un critère
     * 
     * @param string $column Nom de la colonne pour la recherche
     * @param mixed $val Valeur recherchée
     * @return array Tableau des résultats trouvés
     * @throws PDOException Si la recherche échoue
     */
    public function findBy(string $column, mixed $val): array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE $column = ?";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$val]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new PDOException("Erreur lors de la recherche : " . $e->getMessage());
        }
    }
}
