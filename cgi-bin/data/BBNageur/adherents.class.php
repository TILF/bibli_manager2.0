<?php
    namespace data\BBNageur;

    class adherents extends \data\Data
    {
        // Function récupération de toute les infos de tous les adhérents.
        public function getAllAdherents()
        {
            $statement = $this->db->prepare(
                    'SELECT * 
                    FROM adherents
                    WHERE dateFin IS NULL'
                    );
            $statement->execute();
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        }

        // Function d'ajout d'adhérents dans la table
        public function addAdherents($nom, $prenom ,$age, $adresse, $tel, $cotisation, $ville, $zipcode)
        {
            $statement=$this->db->prepare(
                    'INSERT INTO adherents(Nom, Prenom, Age, Adresse, Telephone, Cotisation, Ville, CP)
                    VALUES(:nom, :prenom, :age, :adresse, :tel, :cotisation, :ville, :zipcode)');
            $statement->bindParam(':nom', $nom, \PDO::PARAM_STR);
            $statement->bindParam(':prenom', $prenom, \PDO::PARAM_STR);
            $statement->bindParam(':age', $age, \PDO::PARAM_INT);
            $statement->bindParam(':adresse', $adresse, \PDO::PARAM_STR);
            $statement->bindParam(':tel', $tel, \PDO::PARAM_STR);
            $statement->bindParam(':cotisation', $cotisation, \PDO::PARAM_STR);
            $statement->bindParam(':ville', $ville, \PDO::PARAM_STR);
            $statement->bindParam(':zipcode', $zipcode, \PDO::PARAM_INT);
            $statement->execute();
        }

        // Function de  modification des adhérents
        public function modifyAdherents($id, $nom, $prenom ,$age, $adresse, $tel, $cotisation, $ville, $zipcode)
        {
            $statement = $this->db->prepare(
                    "UPDATE adherents
                    SET
                        Nom = :nom,
                        Prenom = :prenom,
                        Age = :age,
                        Adresse = :adresse,
                        Telephone = :tel,
                        Cotisation = :cotisation,
                        Ville = :ville,
                        CP = :zipcode
                    WHERE Id = :id");
            $statement->bindParam(':nom', $nom, \PDO::PARAM_STR);
            $statement->bindParam(':prenom', $prenom, \PDO::PARAM_STR);
            $statement->bindParam(':age', $age, \PDO::PARAM_INT);
            $statement->bindParam(':adresse', $adresse, \PDO::PARAM_STR);
            $statement->bindParam(':tel', $tel, \PDO::PARAM_STR);
            $statement->bindParam(':cotisation', $cotisation, \PDO::PARAM_STR);
            $statement->bindParam(':ville', $ville, \PDO::PARAM_STR);
            $statement->bindParam(':zipcode', $zipcode, \PDO::PARAM_INT);
            $statement->bindParam(':id', $id, \PDO::PARAM_INT);
            $statement->execute();
        }

        public function deleteAdherents($id)
        {
            $statement=$this->db->prepare(
                    'DELETE
                    FROM adherents
                    WHERE Id = :id');
            $statement->bindParam(':id', $id, \PDO::PARAM_INT);
            $statement->execute();
        }

        public function getExistByNP($nom, $prenom){ 
            $statement = $this->db->prepare(
                'SELECT COUNT(*)
                 FROM adherents
                 WHERE Nom =  :nom
                 AND Prenom = :prenom');
            $statement->bindParam(':nom', $nom, \PDO::PARAM_STR);
            $statement->bindParam(':prenom', $prenom, \PDO::PARAM_STR);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_COLUMN);
        }

        public function getAdherentsbyId($id)
        {
            $statement=$this->db->prepare(
                    'SELECT *
                    FROM adherents
                    WHERE Id = :id');
            $statement->bindParam(':id', $id, \PDO::PARAM_INT);
            $statement->execute();
            return $statement->fetch(\PDO::FETCH_ASSOC);
        }
    }
?>